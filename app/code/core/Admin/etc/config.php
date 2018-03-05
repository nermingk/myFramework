<?php
return [
    'module' => 'Admin',
    'router' => 'admin',
    'version' => '1.0.0',

    'layout' => [
        'default'       => 'fullWidth.phtml',

        'fullWidth'     => 'fullWidth.phtml',
        'leftSidebar'   => 'leftSidebar.phtml',
    ],

    'template' => [
        'html' => array(
            # navigation bar
            'navbar'    => 'html/navbar.phtml',
        ),
        'blank'     => 'blank.phtml',
        'homepage'  => 'homepage.phtml',
        'about'     => 'about.phtml',
    ],
];