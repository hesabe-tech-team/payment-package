<?php

namespace Hesabe\Payment;

use Hesabe\Payment\Payment\Config;

/**
 * Class Payment
 *
 * @author  Fahad Khan  <fkhan@hesabe.com>
 */
class Payment
{

    /**
     * @var  Config
     */
    private $config;
    private $secretKey;
    private $ivKey;
    private $accessCode;

    /**
     * Payment constructor.
     *
     * @param  Config  $config
     * @param $secretKey
     * @param $ivKey
     * @param $accessCode
     */
    public function __construct(Config $config, $secretKey, $ivKey, $accessCode)
    {
        $this->config = $config;
        $this->secretKey = $secretKey;
        $this->ivKey = $ivKey;
        $this->accessCode = $accessCode;
    }

    /**
     * @param $name
     *
     * @return  string
     */
    public function sayHello($name)
    {
        $greeting = $this->config->get('greeting');

        return $greeting . ' ' . $name;
    }

    public function checkout(array $params): string
    {
        $encryptedData = HesabeCrypt::encrypt(json_encode($params), $this->secretKey, $this->ivKey);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.hesbstck.com/checkout",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('data' => $encryptedData),
            CURLOPT_HTTPHEADER => array(
                "accessCode: $this->accessCode",
                "Content-Type: application/json",
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

}
