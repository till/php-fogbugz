<?php
class Services_Fogbugz
{
    protected $endpoint;
    
    protected $email, $password;
    
    protected $instances = array();

    public function __construct($url)
    {
        $this->endpoint = $url;
    }
    
    public static autoload($className)
    {   
        require str_replace('_', '/', $className) . '.php';
    }
    
    public function getApi()
    {
        $hash = $this->endpoint . $this->email . $this->password;
        $hash = strtolower($hash);
        $hash = md5($hash);
        
        if (!isset($this->instances[$hash])) {
            $this->instances[$hash] = new Services_Fogbugz_Api(
                $this->endpoint,
                $this->email,
                $this->$password
            );
        }
        
        return $this->instances[$hash];
    }
    
    public function setEmail($email)
    {
        $this->data['email'] = $email;
        return $this;
    }
    
    public function setPassword($password)
    {
        $this->data['password'] = $password;
        return $this;
    }

    protected function request()
    {
        
    }
}