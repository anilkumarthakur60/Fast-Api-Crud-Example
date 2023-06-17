<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Jobs\PasswordResetJob;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdminController extends Controller
{


    public function login(LoginRequest $request): JsonResource|JsonResponse
    {

        try {
            $user = Admin::whereEmail($request->input('email'))->firstOrFail();
            if (!Hash::check($request->input('password'), $user->password)) {
                throw new Exception('Password is incorrect');
            }
            $token = $user->createToken('Admin Login with admins table  and scope adminApi ', ['adminApi']);
            $user->access_token = $token->accessToken;
            return AdminResource::make($user);
        } catch (Exception $e) {

            return response()->json([
                "message" => "The selected email/password is invalid.",
                "errors" => [
                    "email" => [
                        "The selected email is invalid."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        try {
            DB::beginTransaction();
            $user = Admin::create($data);
            $token = $user->createToken('Admin Login with admins table  and scope adminApi ', ['adminApi']);
            $user->access_token = $token->accessToken;

            DB::commit();
            return AdminResource::make($user);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "The selected email/password is invalid.",
                "errors" => [
                    "email" => [
                        "The selected email is invalid."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function detail(): JsonResource
    {
        $user = auth('admin-api')->user();

        return AdminResource::make($user);
    }


    public function passwordReset(Request $request): JsonResponse
    {
        try {

            $admin = Admin::whereEmail($request->input('email'))->firstOrFail();
            PasswordResetJob::dispatch($admin);

            return response()->json(
                [
                    'message' => 'Password reset link sent on your email id.',
                ],
                ResponseAlias::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }
    }


    public function logout()
    {
        $user = auth('admin-api')->user();

        $user->token()->revoke();

        return response()->json(
            [
                'message' => 'Logout successfully',

            ],
            ResponseAlias::HTTP_OK
        );
    }


    public function refreshToken()
    {
        $user = auth('admin-api')->user();

        $token = $user->createToken('adminToken')->accessToken;

        return response()->json(
            [
                'token' => $token,
            ],
            ResponseAlias::HTTP_OK
        );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|exists:admins,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Admin $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET;



    }
}
