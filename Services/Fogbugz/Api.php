<?php
class Services_Fogbugz_Api extends Services_Fogbugz_Common
{
    public function login()
    {
        $data = array(
            'cmd'      => 'login',
            'email'    => $this->email,
            'password' => $this->password,
        );
        return $this->request($data)
    }
    
    public function logout()
    {
        $data = array(
            'cmd'   => 'logout',
            'token' => $this->token,
        );
        $this->request($data);
    }
    
    public function function list($type)
    {
        $type = strtolower($type);
        
        switch ($type) {
        case 'areas':
        case 'categories':
        case 'mailboxes':
        case 'people':
        case 'priorities':
        case 'projects':
            $cmd = 'list' . ucwords($type);
            break;
        default:
            throw new InvalidArgumentException("Invalid or not supported type.");
            break;
        }
        $data = array(
            'cmd'   => $cmd,
            'token' => $this->token,
        );
        return $this->request($data);
    }
}