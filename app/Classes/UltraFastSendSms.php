<?php

namespace App\Classes;

class UltraFastSendSms
{
    public $templateId = '';

    /**
     * gets API Ultra Fast Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIUltraFastSendUrl()
    {
        return "http://PiraSMS.com/api/UltraFastSend";
    }

    /**
     * gets Api Token Url.
     *
     * @return string Indicates the Url
     */
    protected function getApiTokenUrl()
    {
        return "http://PiraSms.com/api/Token";
    }

    /**
     * gets config parameters for sending request.
     *
     * @param string $APIKey API Key
     * @param string $SecretKey Secret Key
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set("Asia/Istanbul");

        $this->APIKey = "d6b32876247b5e2ee7a70471";
        $this->SecretKey = "09123711964";
    }

    public function activationSms($mobile, $verificationCode)
    {
        $this->data = [
            'ParameterArray' => [
                [
                    'Parameter' => 'VerificationCode',
                    'ParameterValue' => $verificationCode
                ]
            ],
            'Mobile' => $mobile,
            'TemplateId' => '51595'
        ];
        return $this;
    }

    public function reservationSms($mobile, $user, $room, $date, $time, $transaction, $url)
    {
        $this->data = [
            'ParameterArray' => [
                [
                    'Parameter' => 'user',
                    'ParameterValue' => $user
                ],
                [
                    'Parameter' => 'room',
                    'ParameterValue' => $room
                ],
                [
                    'Parameter' => 'date',
                    'ParameterValue' => $date
                ],
                [
                    'Parameter' => 'time',
                    'ParameterValue' => $time
                ],
                [
                    'Parameter' => 'transaction',
                    'ParameterValue' => $transaction
                ],
                [
                    'Parameter' => 'url',
                    'ParameterValue' => $url
                ],
            ],
            'Mobile' => $mobile,
            'TemplateId' => '55708'
        ];
        return $this;
    }

    public function reservationSmsToAdmins($mobile, $userPhone, $user, $room, $date, $time)
    {
        $this->data = [
            'ParameterArray' => [
                [
                    'Parameter' => 'user',
                    'ParameterValue' => $user
                ],
                [
                    'Parameter' => 'room',
                    'ParameterValue' => $room
                ],
                [
                    'Parameter' => 'date',
                    'ParameterValue' => $date
                ],
                [
                    'Parameter' => 'time',
                    'ParameterValue' => $time
                ],
                [
                    'Parameter' => 'mobile',
                    'ParameterValue' => $userPhone
                ],
            ],
            'Mobile' => $mobile,
            'TemplateId' => '56015'
        ];
        return $this;
    }


    /**
     * Ultra Fast Send Message.
     *
     * @param data[] $data array structure of message data
     * @return string Indicates the sent sms result
     */
    public function UltraFastSend()
    {

        $token = $this->GetToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $postData = $this->data;

            $url = $this->getAPIUltraFastSendUrl();
            $UltraFastSend = $this->execute($postData, $url, $token);
            $object = json_decode($UltraFastSend);

            if (is_object($object)) {
                $array = get_object_vars($object);
                if (is_array($array)) {
                    $result = $array['Message'];
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * gets token key for all web service requests.
     *
     * @return string Indicates the token key
     */
    private function GetToken()
    {
        $postData = array(

            'UserApiKey' => $this->APIKey,
            'SecretKey' => $this->SecretKey,
            'System' => 'php_rest_v_1_2'
        );
        $postString = json_encode($postData);

        $ch = curl_init($this->getApiTokenUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'

        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POST, count($postString));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);


        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        if (is_object($response)) {
            $resultVars = get_object_vars($response);

            if (is_array($resultVars)) {
                @$IsSuccessful = $resultVars['IsSuccessful'];
                if ($IsSuccessful == true) {
                    @$TokenKey = $resultVars['TokenKey'];
                    $resp = $TokenKey;
                } else {
                    $resp = false;
                }
            }
        }


        return $resp;
    }

    /**
     * executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string $url url
     * @param string $token token string
     * @return string Indicates the curl execute result
     */
    private function execute($postData, $url, $token)
    {

        $postString = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-sms-ir-secure-token: ' . $token
        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POST, count($postString));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
