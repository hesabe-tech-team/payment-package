<?php

namespace Hesabe\Payment\Tests;

use Hesabe\Payment\Payment;

/**
 * Class PaymentTest
 *
 * @category Test
 * @package  Hesabe\Payment\Tests
 * @author   Fahad Khan <fkhan@hesabe.com>
 */
class PaymentTest extends TestCase
{

    public function testCheckout()
    {
        $secretKey = 'PkW64zMe5NVdrlPVNnjo2Jy9nOb7v1Xg';
        $ivKey = '5NVdrlPVNnjo2Jy9';
        $accessCode = 'c333729b-d060-4b74-a49d-7686a8353481';

        $hesabe = new Payment($secretKey, $ivKey, $accessCode,true);

        $token = $hesabe->checkout([
            "merchantCode" => "842217",
            "amount" => random_int(10, 100),
            "paymentType" => "0",
            "responseUrl" => "http://2.0.test/customer-response?id=842217",
            "failureUrl" => "http://2.0.test/customer-response?id=842217",
            "orderReferenceNumber" => "1604837511",
            "variable1" => null,
            "variable2" => null,
            "variable3" => null,
            "variable4" => null,
            "variable5" => null,
            "version" => "2.0",
        ]);

        self::assertGreaterThan(50, strlen($token), 'Token generation failed');
    }

}
