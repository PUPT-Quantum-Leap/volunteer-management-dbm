<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    public function vote(Request $request, Poll $poll)
    {
        $data = $request->validate([
            'volunteer_id' => 'nullable|integer',
            'option_id' => 'required|integer',
        ]);

        $option = PollOption::where('poll_id', $poll->id)->where('id', $data['option_id'])->firstOrFail();

        // Check poll max votes
        $poll->load('options');
        $totalVotes = $poll->options->sum('votes');
        if ($poll->max_votes !== null && $totalVotes >= $poll->max_votes) {
            return response()->json(['message' => 'Poll has reached the maximum number of votes'], 409);
        }

        DB::transaction(function () use ($option, $poll, $data) {
            // increment option votes
            $option->increment('votes');

            // record vote to prevent double voting
            DB::table('poll_votes')->insert([
                'poll_id' => $poll->id,
                'poll_option_id' => $option->id,
                'volunteer_id' => $data['volunteer_id'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        $poll->load('options');

        return response()->json([
            'id' => $poll->id,
            'question' => $poll->question,
            'max_votes' => $poll->max_votes,
            'total_votes' => $poll->options->sum('votes'),
            'options' => $poll->options->map(fn ($o) => ['id' => $o->id, 'text' => $o->text, 'votes' => $o->votes]),
        ]);
    }
}
