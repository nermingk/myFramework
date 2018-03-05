<?php
class Email_Model_Client extends PHPMailer
{

    /**
     * Email_Model_Client constructor.
     */
    public function __construct()
    {
        $this->_init();
        $this->_debug();
    }


    private function _init()
    {
        $this->isSMTP();

        $this->Host     = App::getConfig('Email','smtp/host');
        $this->Port     = App::getConfig('Email','smtp/port');
        $this->Username = App::getConfig('Email','smtp/username');
        $this->Password = App::getConfig('Email','smtp/password');
        $this->CharSet = 'utf-8';


        $this->SMTPAuth     = true;
        $this->SMTPSecure   = 'ssl'; // Enable TLS encryption, `tls` not working
        $this->Timeout      = 300;

        $this->setFrom(App::getConfig('Email','smtp/sender/email'),App::getConfig('Email','smtp/sender/name'));

        $this->isHTML(true);

        return $this;
    }
    private function _debug()
    {
        if(App::getConfig('Email','debug'))
        {
            $this->SMTPDebug = 2;
            $this->Debugoutput = 'html';
        }

    }
    public function sendTo($recipientEmail)
    {
        $this->addAddress($recipientEmail);
    }

    public function replyTo($replyEmail)
    {
        $this->addReplyTo($replyEmail);
    }

    public function sendCcTo($email)
    {
        $this->addCC($email);
    }

    public function sendBccTo($email)
    {
        $this->addBCC($email);
    }

    public function setSubject($subject)
    {
        $this->Subject = $subject;
    }
    public function setMessage($messageContent)
    {
        $this->Body = $messageContent;
    }
    public function setTemplate($template)
    {
        $emailTemplate = new Core_View_Default();
        $emailTemplate->setTemplate($template);
        $this->msgHTML(file_get_contents($emailTemplate->getTemplatePath()), dirname(__FILE__));
    }
}