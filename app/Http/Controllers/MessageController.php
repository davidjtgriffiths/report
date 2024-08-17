<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Messages/Index', [
            'messages' => Message::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipientEmail' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
        ]);
 
        $request->user()->messages()->create($validated);
 
        return redirect(route('messages.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message): RedirectResponse
    {
        Gate::authorize('update', $message);
 
        $validated = $request->validate([
            'recipientEmail' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
        ]);
 
        $message->update($validated);
 
        return redirect(route('messages.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message): RedirectResponse
    {
        Gate::authorize('delete', $message);
 
        $message->delete();
 
        return redirect(route('messages.index'));
    }
}
