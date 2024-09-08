<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MessageService
{
    public function send(Message $message)
    {
        return DB::transaction(function () use ($message) {
            // Set the 'sent' field to the current datetime
            $message->sent = Carbon::now();
            $message->save();

            // Find or create a new user based on the recipientEmail
            $user = User::firstOrCreate(
                ['email' => $message->recipientEmail],
                [
                    'name' => 'New User', // You might want to generate a name or leave it blank
                    'password' => Hash::make(Str::random(16)), // Generate a random password
                ]
            );

            // Create a new issue
            $issue = new Issue([
                'title' => 'New Issue for ' . $user->email,
                'description' => 'Automatically created issue for new message',
            ]);
            $issue->owner()->associate($user);
            $issue->save();

            // Assign the message to the issue
            $message->issue()->associate($issue);
            $message->save();

            // TODO: Generate a magic login and send the message

            return $message;
        });
    }
}
    
        // TODO: Housekeeping when message sent
        // Sent flag for messages [x]
        // Create user for recipient 
        // Create 'conversation' (issue?)
        // Assign message -> conversation
        // Generate magic login for recipient
        // Email recipient
        // (Message page filters sent)
        // (Conversations page link only shows if user has a message associated with a conversation)
        // Swap to conversations page    
    

    
