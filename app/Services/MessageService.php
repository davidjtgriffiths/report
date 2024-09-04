<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\Cache;

class MessageService
{
    public function blah(string $key, $default = null)
    {
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
    }

    
}