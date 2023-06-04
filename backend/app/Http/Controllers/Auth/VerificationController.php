<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return new JsonResponse(['message' => 'Email already verified.']);
        }

        return new JsonResponse(['message' => 'Verify your email.']);
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return new JsonResponse(['message' => 'Email already verified.']);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));
        }

        return new JsonResponse(['message' => 'Email verified.']);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return new JsonResponse(['message' => 'Email already verified.']);
        }

        $request->user()->sendEmailVerificationNotification();

        return new JsonResponse(['message' => 'Email verification link resent.']);
    }
}
