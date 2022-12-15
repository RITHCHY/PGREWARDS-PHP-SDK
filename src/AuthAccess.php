<?php

namespace Mds\PGRewards;

abstract class AuthAccess{
    
    private $auth = null;

    protected function getAuthAccess(): Auth{
        return $this->auth;
    }

    protected function getAuthConfigEnpoint(): string{
        return $this->auth->getConfig()['endpoint'];
    }

    protected function getAuthAccessToken(): string{
        return $this->auth->getAuthInformations()->token;
    }
    
    public function withAuth(Auth $auth) {
        if($auth instanceof Auth){
            $this->auth = $auth;
            return $this;
        }
        throw new \Exception("auth must be an instance of Auth");
    }
    
}