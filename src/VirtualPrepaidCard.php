<?php

namespace Mds\PGRewards;

use Mds\PGRewards\Constants;
use Mds\PGRewards\AuthAccess;

class VirtualPrepaidCard extends AuthAccess{

    private $email;
    private $fullName;
    private $amount;
    private $person;
    private $billingAddress;
    private $isPhysical;

    public function __construct(Array $virtualPrepaidCardInformations) {
        $this->setEmail($virtualPrepaidCardInformations['email'])
             ->setFullName($virtualPrepaidCardInformations['fullName'])
             ->setAmount($virtualPrepaidCardInformations['amount'])
             ->setPerson($virtualPrepaidCardInformations['person'])
             ->setBillingAddress($virtualPrepaidCardInformations['billingAddress'])
             ->setIsPhysical($virtualPrepaidCardInformations['isPhysical']);
    }

    public function setEmail(string $email) {
        if(Utils::validateEmail($email)){
            $this->email = $email;
            return $this;
        }
        throw new \Exception("Invalid email");
    }

    public function setFullName(string $fullName) {
        $this->fullName = $fullName;
        return $this;
    }

    public function setAmount(float $amount) {
        if($amount >= Constants::$MINIMUM_AMOUNT && $amount <= Constants::$MAXIMUM_AMOUNT){
            $this->amount = $amount;
            return $this;
        }
        throw new \Exception("Amount must be greater than 7.99 and less than 1000.0");
    }

    public function setPerson(string $person) {
        if (in_array($person, Constants::$PERSON_TYPES)) {
            $this->person = $person;
            return $this;
        }
        throw new \Exception("Invalid person type");
    }

    public function setBillingAddress(Array $billingAddress) {
        if(is_array($billingAddress) 
            && array_keys($billingAddress) == ['line1', 'city', 'state', 'country', 'postal_code']){
            $this->billingAddress = $billingAddress;
            return $this;
        }
        throw new \Exception("Billing address must be an array with keys: line1, city, state, country, postal_code");
    }

    public function setIsPhysical(bool $isPhysical) {
        if(is_bool($isPhysical)){
            $this->isPhysical = $isPhysical;
            return $this;
        }
        throw new \Exception("isPysical must be a boolean");
    }

    public function create(){

        if(!is_null($this->getAuthAccess())){
        
            $endpoint = $this->getAuthConfigEnpoint().Constants::$API_CREATE_VIRTUAL_PREPAID_CARD_URI;
            $authToken = $this->getAuthAccessToken();

            $client = new \GuzzleHttp\Client();
            try {
                $res = $client->request('POST', $endpoint, [
                    'json' => [
                        'email' => $this->email,
                        'fullName' => $this->fullName,
                        'amount' => $this->amount,
                        'person' => $this->person,
                        'billingAddress' => $this->billingAddress,
                        'isPhysical' => $this->isPhysical
                    ],
                    'headers' => [
                        "Accept" => Constants::$HTTP_ACCEPT_HEADER,
                        "Authorization" => "Bearer $authToken"
                    ]
                ]);

                return json_decode($res->getBody()->getContents());

            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                throw new \Exception($e->getMessage());
            }     
        }else{
            throw new \Exception("Auth access token is null");
        }
    }
}