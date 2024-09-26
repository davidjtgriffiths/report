<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Issue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\AppSettingService;
use App\Services\IssueService;

class IssueController extends Controller
{
    private $appSettingService;
    private $issueService;

    public function __construct(
        AppSettingService $appSettingService,
        IssueService $issueService,
    ){
        $this->appSettingService = $appSettingService;
        $this->issueService = $issueService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Issues/Index', [
            'issues' => Issue::with('owner:id,name')->latest()->get(),
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
 
        $request->user()->issues()->create($validated);
 
        return redirect(route('issues.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): Response
    {
        // TODO: authorise show issue
        // Gate::authorize('show', $issue);

        // $issue = Issue::findOrFail($id);
        $issue = Issue::with('messages')->findOrFail($id);

        return Inertia::render('Issues/Show', [
            'issue' => $issue,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Issue $issue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Issue $issue): RedirectResponse
    {
        // dd($issue);
        Gate::authorize('update', $issue);
 
        $validated = $request->validate($this->getValidationRules());
 
        $issue->update($validated);
 
        return redirect(route('issues.index'));
    }

    public function send(Request $request, $issueId)
    {
        $issue = Issue::findOrFail($issueId);
        
        // Assuming the recipientEmail is already set on the issue
        // If not, you might want to add it here based on the request data

        $sentIssue = $this->issueService->send($issue);

        return response()->json(['issue' => 'Issue sent successfully', 'data' => $sentIssue]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issue $issue): RedirectResponse
    {
        Gate::authorize('delete', $issue);
 
        $issue->delete();
 
        return redirect(route('issues.index'));
    }
    
    /**
     * Return validation rules for issue.
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
