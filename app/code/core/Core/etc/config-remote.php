<?php
return array(
    'module' => 'Core',
    'router' => 'home',
    'version' => '1.0.0',
    'title' => 'Core Title',

    # Database
    # todo: NOTICE DATABASE CONNECTION
    'database' => array(
        'host'      => 'localhost',
        'dbname'    => 'bnpze_saradnja',
        'username'  => 'bnpze_admin',
        'password'  => 'iQ*fX#uq6Op6',
    ),

    # form security key
    'formkey' => 'N18oaijsIhA938ia85fTwv0J7tQ',

    # layout paths relative to app root
        'layoutPath' =>array(
                'admin' => array(
                    'core'  => '/design/admin/core/layout/',
                    'local' => '/design/admin/local/layout/',
                ),
                'frontend'  => array(
                    'core'  => '/design/frontend/core/layout/',
                    'local' => '/design/frontend/local/layout/',
                ),
        ),
    # template paths relative to app root
        'templatePath' =>array(
                'admin' => array(
                    'core'  => '/design/admin/core/template/',
                    'local' => '/design/admin/local/template/',
                ),
                'frontend'  => array(
                    'core'  => '/design/frontend/core/template/',
                    'local' => '/design/frontend/local/template/',
                ),
        ),

    'layout' => array(
        'default'       => 'leftSidebar.phtml',
        'fullWidth'   => 'fullWidth.phtml',

    ),

    'template' => array(
        # html head and page buttom (before </body> close)
        'html' => array(
            # <head> / css, favicon etc.
            'head'      => 'html/head.phtml',
            # before </body> / js etc.
            'bottom'    => 'html/bottom.phtml',
            # sidebar
            'sidebar'   => 'html/sidebar.phtml',
            # navigation bar
            'navbar'    => 'html/navbar.phtml',
        ),

        'blank'     => 'blank.phtml',
        'homepage'  => 'homepage.phtml',
        'about'     => 'about.phtml',
    ),

    # Skin settings
    'skin' => array(

        # package in use
        'path' => '/skin/default/',

        # css files relative to '/skin/path/'
        'cssFiles' => array(

            # bootstrap css
            'css/bootstrap.min.css',
            'css/ie10-viewport-bug-workaround.css',
            'css/font-awesome.min.css',

            # other css files
            'css/dashboard.css',
            'css/prijava.css',
        ),

        # less On/Off
        'useLess' => false,
        # main less file relative to '/skin/path/'
        'lessFile' => 'less/_app.less',

        # js files relative to '/skin/path/'
        'jsFiles' => array(),

        # favicon relative to '/skin/path/'
        //'favicon' => 'images/favicon-dev.ico',
        'favicon' => 'images/favicon.ico',

        # images folder
        'images' => 'images/',
    ),

);