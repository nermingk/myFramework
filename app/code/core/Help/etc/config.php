<?php
return array(
    'module' => 'Help',
    'router' => 'help',
    'version' => '1.0.0',
    'layout' => array(
        'default'       => 'leftSidebar.phtml',
    ),
    'template' => array(
        'homepage'  => 'help/homepage.phtml',
        'layout'    => 'help/layout.phtml',
        'module'    => 'help/module.phtml'
    ),

);