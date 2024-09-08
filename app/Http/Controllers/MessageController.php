<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\AppSettingService;
use App\Services\MessageService;

class MessageController extends Controller
{
    private $appSettingService;
    private $messageService;

    public function __construct(
        AppSettingService $appSettingService,
        MessageService $messageService,
    ){
        $this->appSettingService = $appSettingService;
        $this->messageService = $messageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Messages/Index', [
            'messages' => Message::with('user:id,name')->latest()->get(),
            'testAppVar' => $this->appSettingService->get('testAppVar'),
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
        $validated = $request->validate($this->getValidationRules());
 
        $request->user()->messages()->create($validated);
 
        return redirect(route('messages.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): Response
    {
        // TODO: authorise show message
        // Gate::authorize('show', $message);

        $message = Message::findOrFail($id);
        return Inertia::render('Messages/Show', [
            'message' => $message,
        ]);

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
        // dd($message);
        Gate::authorize('update', $message);
 
        $validated = $request->validate($this->getValidationRules());
 
        $message->update($validated);
 
        return redirect(route('messages.index'));
    }

    public function send(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Assuming the recipientEmail is already set on the message
        // If not, you might want to add it here based on the request data

        $sentMessage = $this->messageService->send($message);

        return response()->json(['message' => 'Message sent successfully', 'data' => $sentMessage]);
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
    
    /**
     * Return validation rules for message.
     */
    protected function getValidationRules(): array
    {
        return [
            'recipientEmail' => [
                'nullable',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $userDomain = substr(Auth::user()->email, strrpos(Auth::user()->email, '@') + 1);
                        $recipientDomain = substr($value, strrpos($value, '@') + 1);
        
                        if ($recipientDomain !== $userDomain) {
                            $fail("The recipient email must be from the same domain as your email ({$userDomain}).");
                        }
                    }
                },
            ],
            'subject' => 'required|string|max:255',
        ];
    }
}
