<?php

namespace App\Jobs;

use App\Models\Admin;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;


class PasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Admin $admin)
    {
    }

    public function handle(): void
    {
        ResetPassword::createUrlUsing(function (Admin $admin, string $token) {
            return "http://127.0.0.1:8000/api/reset-password?token=$token";
        });
        $this->admin->sendPasswordResetNotification(
            Password::broker()->createToken($this->admin)
        );
    }
}
