<?php
return array(
    'module' => 'Prijava',    // Same as Module name
    'router' => 'prijava',     // Required field. Leave empty if no routing
    'version' => '1.0.0',
    'layout' => array(
        'default'       => 'leftSidebar.phtml',
    ),
    'template' => array(
        'index' => 'prijava/index.phtml',
        'success' => 'prijava/success.phtml',

        'section' => array(
            'index' => 'prijava/section/index.phtml',
            'add'   => 'prijava/section/add.phtml',
            'edit'  => 'prijava/section/edit.phtml',
        ),
    ),

    'folder' => array(
        'upload' => 'upload/prijava/', // without leading slash
    ),

    'file' => array(
        'image' => array(
            'resize' => 1, // resize image after upload
        ),
    ),

    'email' => array(
        # email to subscriber
        'confirmation' => array(
            'template' => 'prijava/email/confirmation.phtml',
            'subject' => 'Potvrda prijave o saradnji',
            'bcc' => array(), // add addres as array
            'reply' => "", // reply to email address (as string)
        ),
        'admin' => array(
            'address' => 'hazim.begagic@gmail.com', // todo: direktorov email
            //'address' => 'nermingk@live.com',
            'subject' => "Nova prijava za saradnju",
            'bcc' => array('info@bnp.ba','pr@bnp.ba'),
            'attachments' => array(
                'enabled' => 1, // 0 = do not include attachemnts
                'image' => 1 // 0 = do not attach image
            ),
        ),
    ),
);