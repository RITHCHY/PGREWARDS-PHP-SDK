<?php 


namespace Mds\PGRewards;

use Mds\PGRewards\Constants;

class Auth{

    private $userID;
    private $secretKey;
    private $config;

    
    public function __construct(string $userID, string $secretKey, Array $config) {
        $this->setUserID($userID)
             ->setSecretKey($secretKey)
             ->setConfig($config);
    }

    public function getConfig(): Array {
        return $this->config;
    }

    public function setUserID(string $userID) {
        $this->userID = $userID;
        return $this;
    }

    public function setSecretKey(string $secretKey) {
        $this->secretKey = $secretKey;
        return $this;
    }

    public function setConfig(Array $config) {
        if(is_array($config) && array_key_exists('endpoint', $config)){
            $this->config = $config;
            return $this;
        }
        throw new \Exception("Invalid config");
    }
    
    public function getAuthInformations(): \stdClass{
        $endpoint = $this->config['endpoint'].Constants::$API_TOKEN_URI;
        $client = new \GuzzleHttp\Client();

        try{   
            $res = $client->request('POST', $endpoint, [
                'json' => [
                    'userID' => $this->userID,
                    'secretKey' => $this->secretKey
                ], 
                'headers' => [
                    "Accept" => Constants::$HTTP_ACCEPT_HEADER
                ]
            ]);

            return json_decode($res->getBody()->getContents());

        }catch(\GuzzleHttp\Exception\ClientException $e){
            throw new \Exception(
                $e->getResponse()->getBody()->getContents()
            );
        }
    }

    public function getBalance(){
        
        $endpoint = $this->config['endpoint'].Constants::$BALANCE_URI;
        $authToken = $this->getAuthInformations()->token;

        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('POST', $endpoint, [
                'json' => [
                    'userID' => $this->userID,
                ],
                'headers' => [
                    "Accept" => Constants::$HTTP_ACCEPT_HEADER,
                    "Authorization" => "Bearer $authToken"
                ]
            ]);

            return json_decode($res->getBody());

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new \Exception(
                $e->getResponse()->getBody()->getContents()
            );
        }
    }

}