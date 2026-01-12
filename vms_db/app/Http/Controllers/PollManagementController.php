<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollManagementController extends Controller
{
    public function create()
    {
        return view('poll-create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'question' => 'required|string|max:500',
                'max_votes' => 'nullable|integer|min:1',
                'options' => 'required|array|min:2',
                'options.*' => 'required|string|max:255',
            ]);

            $poll = Poll::create([
                'question' => $validated['question'],
                'max_votes' => $validated['max_votes'] ?? null,
            ]);

            // Create options for the poll
            foreach ($validated['options'] as $optionText) {
                $poll->options()->create([
                    'text' => $optionText,
                    'votes' => 0,
                ]);
            }

            return redirect('/polls/manage')->with('success', 'Poll created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function index()
    {
        $polls = Poll::with('options')->get();

        return view('poll-manage', ['polls' => $polls]);
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();

        return redirect('/polls/manage')->with('success', 'Poll deleted successfully!');
    }
}
