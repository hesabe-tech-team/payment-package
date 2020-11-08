<?php

namespace Hesabe\Payment;

/**
 * Class Payment
 *
 * @author  Fahad Khan  <fkhan@hesabe.com>
 */
class Payment
{
    private $secretKey;
    private $ivKey;
    private $accessCode;
    private $test;

    /**
     * Payment constructor.
     *
     * @param $secretKey
     * @param $ivKey
     * @param $accessCode
     * @param  bool  $test
     */
    public function __construct($secretKey, $ivKey, $accessCode, $test = false)
    {
        $this->secretKey = $secretKey;
        $this->ivKey = $ivKey;
        $this->accessCode = $accessCode;
        $this->test = $test;
    }

    public function checkout(array $params): string
    {
        $encryptedData = HesabeCrypt::encrypt(json_encode($params), $this->secretKey, $this->ivKey);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getRedirectBaseUrl()."/checkout",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('data' => $encryptedData),
            CURLOPT_HTTPHEADER => array(
                "accessCode: $this->accessCode",
                "Accept: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $decryptedResponse = HesabeCrypt::decrypt($response, $this->secretKey, $this->ivKey);
        $jsonData = json_decode($decryptedResponse, true);

        if (isset($jsonData['status']) && !$jsonData['status']) {
            return 'Something went wrong';
        }

        return $jsonData['response']['data'];
    }

    public function getRedirectBaseUrl(): string
    {
        $endpoints = [
            true => 'https://sandbox.hesabe.com',
            false => 'https://api.hesabe.com'
        ];

        return $endpoints[$this->test];
    }
}
