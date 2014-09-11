<?php
/**
 * The production database settings. These get merged with the global settings.
 */

return array(
    'default' => array(
        'connection'  => array(
            'dsn'        => 'mysql:host=localhost;dbname=product',
            'username'   => 'product',
            'password'   => 'motorcars5_decentralizationists',
        ),
        'table_prefix'   => 'buff_'
    ),
);
