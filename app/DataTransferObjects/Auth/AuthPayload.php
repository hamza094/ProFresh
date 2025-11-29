<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Auth;

use App\Models\User;
use App\Http\Resources\Api\V1\UsersResource;

final class AuthPayload
{
    public function __construct(
        public User $user,
        public ?string $accessToken = null,
        public string $message = 'User authenticated successfully',
        public string $status = 'success',
    ) {}

    /**
     * Convert to array suitable for JSON response.
     */
    public function toArray(): array
    {
        $data = [
            'message' => $this->message,
            'user' => new UsersResource($this->user),
            'status' => $this->status,
        ];

        if ($this->accessToken !== null) {
            $data['access_token'] = $this->accessToken;
        }

        return $data;
    }
}
