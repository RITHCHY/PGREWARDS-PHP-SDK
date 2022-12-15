<?php

namespace Mds\PGRewards;

// use Mds\PGRewards\Auth;
use Mds\PGRewards\Utils;
use Mds\PGRewards\Constants;
use Mds\PGRewards\AuthAccess;

class Rewards extends AuthAccess{

    private $email;
    private $amount;

    public function __construct(string $email, float $amount) {
        $this->setEmail($email)
             ->setAmount($amount);
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setEmail(string $email) {
        if(Utils::validateEmail($email)){
            $this->email = $email;
            return $this;
        }
        throw new \Exception("Invalid email");
    }

    public function setAmount(float $amount) {
        if($amount >= Constants::$MINIMUM_AMOUNT && $amount <= Constants::$MAXIMUM_AMOUNT){
            $this->amount = $amount;
            return $this;
        }
        throw new \Exception("Amount must be greater than 8.0 and less than 1000.0");
    }

    public function sendByEmail(){

        if(!is_null($this->getAuthAccess())){ 

            $endpoint = $this->getAuthConfigEnpoint().Constants::$API_SEND_REWARDS_URI;
            $authToken = $this->getAuthAccessToken();

            $client = new \GuzzleHttp\Client();
            try{   
                $res = $client->request('POST', $endpoint, [
                    'json' => [
                        'token' => $authToken,
                        'email' => $this->email,
                        'amount' => $this->amount
                    ], 
                    'headers' => [
                        "Accept" => Constants::$HTTP_ACCEPT_HEADER,
                        "Authorization" => "Bearer $authToken"
                    ]
                ]);

                return json_decode($res->getBody()->getContents());

            }catch(\GuzzleHttp\Exception\ClientException $e){
                throw new \Exception($e->getMessage());
            } 

        }else{
            throw new \Exception("Auth is required");
        } 
    }
}
