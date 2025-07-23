<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\V1\UsersResource;
use App\Http\Requests\Api\V1\Auth\PrepareTwoFactorRequest;
use App\Http\Requests\Api\V1\Auth\ConfirmTwoFactorRequest;
use App\Http\Requests\Api\V1\Auth\TwoFactorLoginRequest;
use App\Http\Requests\Api\V1\Auth\DisableTwoFactorRequest;
use Illuminate\Http\JsonResponse;
use App\Enums\TwoFactorStatus;

/**
 * Two-Factor Authentication Controller
 * 
 * Handles all 2FA operations including setup, confirmation, login, and management.
 */
class TwoFactorController extends Controller
{

    /**
     * Get the current 2FA status for the authenticated user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserStatus(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasTwoFactorEnabled()) {
            return response()->json(['status' => TwoFactorStatus::ENABLED->value]);
        }

        $pending = $user->twoFactorAuth()->whereNull('enabled_at')->first();

        if ($pending) {
            return response()->json([
                'qr_code' => $pending->toQr(),
                'uri'     => $pending->toUri(),
                'string'  => $pending->toString(),
                'status'  => TwoFactorStatus::IN_PROGRESS->value,
            ]);
        }

        return response()->json(['status' => TwoFactorStatus::DISABLED->value]);
    }


    /**
     * Prepare 2FA setup by creating a new secret
     * 
     * @param PrepareTwoFactorRequest $request
     * @return JsonResponse
     */
    public function prepareTwoFactor(PrepareTwoFactorRequest $request): JsonResponse
    {
        $user = $request->user();
        $secret = $user->createTwoFactorAuth();

        return response()->json([
            'qr_code' => $secret->toQr(),
            'uri'     => $secret->toUri(),
            'string'  => $secret->toString(),
            'status'  => TwoFactorStatus::IN_PROGRESS->value,
        ], 200);
    }

    /**
     * Confirm 2FA setup with verification code
     * 
     * @param ConfirmTwoFactorRequest $request
     * @return JsonResponse
     */
    public function confirmTwoFactor(ConfirmTwoFactorRequest $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'message' => TwoFactorStatus::SUCCESS->value,
            'recoveryCodes' => $user->getRecoveryCodes(),
            'status' => TwoFactorStatus::ENABLED->value,
        ]);
    }


    /**
     * Complete 2FA login with verification code
     * 
     * @param TwoFactorLoginRequest $request
     * @return JsonResponse
     */
    public function twoFactorLogin(TwoFactorLoginRequest $request): JsonResponse
    {
        $user = $request->user();
        
        // Clear the 2FA session after successful login
        session()->forget('2fa_login');
        
        return response()->json([
            'message' => 'User authenticated successfully',
            'user' => new UsersResource($user),
            'status' => TwoFactorStatus::SUCCESS->value,
            'access_token' => $user->createToken(
                'Api Token for ' . $user->email,
                ['*'],
                now()->addMonth()
            )->plainTextToken,
        ], 200);
    }


    /**
     * Show and regenerate recovery codes
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function showRecoveryCodes(Request $request): JsonResponse
    {
        $recoveryCodes = $request->user()->generateRecoveryCodes();

        return response()->json([
            'message' => TwoFactorStatus::SUCCESS->value,
            'recoveryCodes' => $recoveryCodes,
        ]);
    }

    /**
     * Disable 2FA for the authenticated user
     * 
     * @param DisableTwoFactorRequest $request
     * @return JsonResponse
     */
    public function disableTwoFactorAuth(DisableTwoFactorRequest $request): JsonResponse
    {
        $request->user()->disableTwoFactorAuth();
        
        return response()->json([
            'message' => 'Two-Factor Authentication has been disabled!',
            'status' => TwoFactorStatus::DISABLED->value,
        ]);
    }
}
