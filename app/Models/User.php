<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Services\AppSettingService;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'name',
    ];

    protected $appends = ['can_send_message'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    // Custom attribute to determine if the user can send a message
    public function getCanSendMessageAttribute()
    {
        // Define the time period during which the user cannot send a new message
        $timePeriod = 60; // e.g., 60 minutes
        $instance = new AppSettingService();
        $timePeriod = $instance->get('daysBetweenSendingMessages');


        // Get the latest message sent by the user
        $latestMessage = $this->messages()->whereNotNull('sent')->latest('sent')->first();

        if (!$latestMessage) {
            // If no messages have been sent, the user can send a message
            return true;
        }

        // Calculate the time difference
        $now = Carbon::now();
        $timeSinceLastMessage = abs($now->diffInDays($latestMessage->sent));

        dump($timeSinceLastMessage >= $timePeriod);
        // Check if the user can send a message based on the time period
        return $timeSinceLastMessage >= $timePeriod;

    }
}
