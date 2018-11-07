<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/7/18
 * Time: 7:44 AM
 */

namespace App\Tests\Security;

use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testRandomTokenGeneration()
    {
        $randomTokenGenerator = new TokenGenerator();
        $length = 30;
        $token = $randomTokenGenerator->generateRandomToken($length);
//        $token[15] = '-';
        echo $token;

        $this->assertEquals($length, strlen($token));
        $this->assertEquals(1, preg_match('/^[A-Za-z0-9]{' . $length . '}$/', $token));
        $this->assertTrue(ctype_alnum($token), 'Token contains invalid characters');
    }
}