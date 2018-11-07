<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/6/18
 * Time: 12:56 PM
 */

namespace App\Security;


class TokenGenerator
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public function generateRandomToken(int $length): string
    {
        $maxLength = strlen(self::ALPHABET);
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= self::ALPHABET[rand(0, $maxLength - 1)];
        }

        return $token;
    }
}
