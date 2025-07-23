<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UserTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            /*
             * @example "My API Token"
             */
            'name' => 'required|string|max:255',

            /*
             * @example "2025-12-31 23:59:59"
             * 
             * The expiry date of the token (Y-m-d H:i:s).
             * 
             * Must not be more than 180 days from now.
             */
            'expires_at' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $maxDate = now()->addDays(180);
                        if (now()->parse($value)->gt($maxDate)) {
                            $fail('The ' . $attribute . ' may not be more than 180 days from now.');
                        }
                    }
                }
            ],
        ];
    }
}
