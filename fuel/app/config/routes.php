<?php
return array(
	'_root_'  => 'home/index',  // The default route
	'_404_'   => 'home/404',    // The main 404 route
    'login' => 'user/login',
    'logout' => 'user/logout',
    'register' => 'user/register',
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);