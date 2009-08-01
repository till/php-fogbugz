<?php
/**
 * +-----------------------------------------------------------------------+
 * | Copyright (c) 2009, Till Klampaeckel                                  |
 * | All rights reserved.                                                  |
 * |                                                                       |
 * | Redistribution and use in source and binary forms, with or without    |
 * | modification, are permitted provided that the following conditions    |
 * | are met:                                                              |
 * |                                                                       |
 * | o Redistributions of source code must retain the above copyright      |
 * |   notice, this list of conditions and the following disclaimer.       |
 * | o Redistributions in binary form must reproduce the above copyright   |
 * |   notice, this list of conditions and the following disclaimer in the |
 * |   documentation and/or other materials provided with the distribution.|
 * | o The names of the authors may not be used to endorse or promote      |
 * |   products derived from this software without specific prior written  |
 * |   permission.                                                         |
 * |                                                                       |
 * | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
 * | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
 * | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
 * | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
 * | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
 * | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
 * | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
 * | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
 * | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
 * | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
 * | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
 * |                                                                       |
 * +-----------------------------------------------------------------------+
 * | Author: Till Klampaeckel <till@php.net>                               |
 * +-----------------------------------------------------------------------+
 *
 * PHP version 5
 *
 * @category Services
 * @package  Services_Fogbugz
 * @author   Till Klampaeckel <till@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version  GIT: $Id$
 * @link     http://github.com/till
 */
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