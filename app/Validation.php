<?php

namespace App;

use Illuminate\Support\Facades\Validator;

class Validation
{
    public static function validateEmail($email)
    {
        $validator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email']]
        );

        if ($validator->fails()) {
            return [
                'value' => $email,
                'valid' => false,
                'error' => 'Please enter a valid email address.',
            ];
        }

        return [
            'value' => $email,
            'valid' => true,
            'error' => null,
        ];
    }

    public static function validateName($name)
    {
        $trimmed = trim($name);
        $rules   = [
            'name' => ['required', 'string', 'min:3', 'max:20', 'regex:/^[A-Za-z ]+$/'],
        ];
        $messages = [
            'name.min'   => 'Name must be between 3 and 20 characters.',
            'name.max'   => 'Name must be between 3 and 20 characters.',
            'name.regex' => 'Name can only contain letters and spaces.',
        ];

        $validator = Validator::make(['name' => $trimmed], $rules, $messages);

        if ($validator->fails()) {
            // Return the first error message found
            $error = $validator->errors()->first('name');

            return [
                'value' => $name,
                'valid' => false,
                'error' => $error,
            ];
        }

        return [
            'value' => $name,
            'valid' => true,
            'error' => null,
        ];
    }

    public static function validatePassword($password)
    {
        $rules = [
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // at least one lowercase letter
                'regex:/[A-Z]/',      // at least one uppercase letter
                'regex:/[0-9]/',      // at least one number
                'regex:/[!@#$%^&*()_+\-=\[\]{};\'":\\|,.<>\/?]/',  // at least one special char
            ],
        ];

        $messages = [
            'password.min'   => 'Password must be at least 8 characters long.',
            'password.regex' => function ($attribute, $value, $fail) use ($password) {
                if (!preg_match('/[a-z]/', $password)) {
                    $fail('Password must contain at least one lowercase letter.');
                } elseif (!preg_match('/[A-Z]/', $password)) {
                    $fail('Password must contain at least one uppercase letter.');
                } elseif (!preg_match('/[0-9]/', $password)) {
                    $fail('Password must contain at least one number.');
                } elseif (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\'":\\|,.<>\/?]/', $password)) {
                    $fail('Password must contain at least one special character.');
                }
            },
        ];

        $validator = Validator::make(['password' => $password], $rules, $messages);

        if ($validator->fails()) {
            $error = $validator->errors()->first('password');

            return [
                'value' => $password,
                'valid' => false,
                'error' => $error,
            ];
        }

        return [
            'value' => $password,
            'valid' => true,
            'error' => null,
        ];
    }
}
