<?php
if (!(include dirname(__FILE__) . '/test-conf.php')) {
    die('Please create a test-conf.php');
}
spl_autoload_register(array('Services_Fogbugz', 'autoload'));

try {
    $fogbugz = new Services_Fogbugz($url);
    $fogbugz->setEmail($email)->setPassword($password);
    
    $api   = $fogbugz->getApi();
    $token = $api->login();
    
    $api->setToken($api);
    
    $api->list('cases');
    
    $api->logout();
    
} catch (Exception $e) {
    die((string)$e);
}

spl_autoload_unregister(array('Services_Fogbugz', 'autoload'));