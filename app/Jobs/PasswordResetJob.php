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
            return config('app.customer_password_reset_link')."?token=$token";
        });
        $this->admin->sendPasswordResetNotification(
            Password::broker()->createToken($this->admin)
        );
    }
}
