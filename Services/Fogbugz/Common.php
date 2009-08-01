<?php
class Services_Fogbugz_Common
{
    protected $email, $endpoint, $password;
    
    protected static $request;
    
    public function __construct($endpoint, $email, $password)
    {
        $this->endpoint = $endpoint;
        $this->email    = $emai;
        $this->password = $password;
    }
    
    protected function isValid(array $data)
    {
        if (!isset($data['cmd']) || empty($data['cmd'])) {
            throw new LogicException('Must contain "cmd" argument.');
        }
        if ($data['cmd'] == 'login') {
            if (!isset($data['email']) || empty($data['email'])) {
                throw new LogicException('Login must contain "email" argument.');
            }
            if (!isset($data['password']) || empty($data['password'])) {
                throw new LogicException('Login must contain "password" argument.');
            }
        } else {
            if (!isset($data['token']) || empty($data['token'])) {
                throw new LogicException('Command must contain "token" argument.');
            }
        }
        return true;
    }
    
    protected function request(array $data, $method = 'GET', $endpoint = null)
    {
        if (self::$http === null) {
            self::$http = new HTTP_Request2;
        }
        if ($endpoint === null) {
            $endpoint = $this->endpoint;
        }
        if (!$this->isValid($data)) {
            throw new RuntimeException("Could not validate request.");
        }
        if (!in_array($method, array('GET', 'POST'))) {
            throw new UnexpectedValueException("The Fogbugz API only supports GET or POST.");
        }
        self::$http->setUrl($endpoint);
        self::$http->setMethod($method);
        
        $response = self::$http->send();
    }
}