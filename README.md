# Hesabe Payment Package

[![Latest Stable Version](https://poser.pugx.org/nextpack/nextpack/v/stable)](https://packagist.org/packages/nextpack/nextpack) 
[![License](https://poser.pugx.org/nextpack/nextpack/license)](https://packagist.org/packages/nextpack/nextpack)
[![Fahad Khan](https://img.shields.io/badge/Author-Fahad%20Khan-orange.svg)](https://hesabe.com)

**Hesabe Payment Package** is a PHP package designed to integrate Hesabe Payment Gateway in your application in the easiest way possible.

Get in touch with [Hesabe Support](mailto:support@hesabe.com) to get credentials in order to use this package.

## Requirements
1. Minimum PHP 7.0+ required
2. [Composer](https://getcomposer.org) installed globally

## Installation
1. Run the following command in the root of your PHP project:
    ```
    composer require hesabe/payment
    ```
2.  Import the `Payment` class in the file you want to use this package.
    ```
    use Hesabe\Payment\Payment; 
    ```
3. Initialise the `Hesabe` instance using `Payment` class. 
You need to pass the credentials in the class parameters.
    ```
    $hesabe = new Payment(
                __SECRET_KEY__,
                __IV_KEY__,
                __ACCESS_CODE__,
                true
            );
    ```
   The last parameter is a boolean which indicates that `test` which environment are you on.
   - `true`  = Sandbox
   - `false` = Production
    
   By default, the value will be `false`.
   
4. Call the `checkout` method to get the token from `Hesabe` by passing the request parameters in an array.
    ```
    $token = $hesabe->checkout([
                "merchantCode" => __MERCHANT_CODE__,
                "amount" => "1",
                "paymentType" => "0",
                "responseUrl" => "http://yourlink.com",
                "failureUrl" => "http://yourlink.com",
                "orderReferenceNumber" => "",
                "variable1" => null,
                "variable2" => null,
                "variable3" => null,
                "variable4" => null,
                "variable5" => null,
                "version" => "2.0",
            ]);
    ```
   These are the basic parameters which are passed to get a token, for more information about these parameters you may have a look [here](https://developer.hesabe.com/index.html#posting-payment-data).

5. The final step, You'll receive a `string` type in the `$token`. You need to pass the token as a redirection to the Payment URL.
    ```
    header("Location: $hesabe->getRedirectBaseUrl()/payment?data=$token");
    ```
    You should be redirected to the Hesabe Payment page.

## Credits

- [Fahad Khan](https://github.com/fkhan-hesabe)

## License

The MIT License (MIT). See the [License File](https://github.com/nextpack/nextpack/blob/master/LICENSE) for more information.
