<?php
return array(
    'module' => 'Email',
    'router' => 'email',
    'version' => '1.0.0',

    'debug' => 0, // set '0' for live mode or '1' for debug display

    'smtp' => array(
        'username'  => 'info@bnp.ba',
        'password'  => 'z$#$#T;6R3vf',
        'host'      => 'sumida.websitewelcome.com',
        'port'      => '465',

        'sender' => array(
            'email' => 'info@bnp.ba',
            'name'  => 'BNP Zenica'
        ),
    ),
);