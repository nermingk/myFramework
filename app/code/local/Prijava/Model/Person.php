<?php
class Prijava_Model_Person extends Core_Model_Abstract
{
    protected function _init()
    {
        $this->setTable('person');
        $this->setIdFieldName('id');
    }

    /**
     * @return bool
     * @throws Exception
     * @throws phpmailerException
     */
    public function sendConfirmationEmail()
    {
        $recipientEmail = $this->getEmail();

        if(!trim($recipientEmail)) throw new Exception("Can't send confirmation. Email field is empty.");

        $config = App::getConfig('Prijava','email/confirmation');

        # load data from module config
        $subject    = $config['subject'];
        $template   = $config['template'];
        $bcc        = $config['bcc'];
        $replyTo    = $config['reply'];

        $email = new Email_Model_Client();

        $email->sendTo($recipientEmail);
        $email->setSubject($subject);
        $email->setTemplate($template);

        # add BCC
        if(!empty($bcc))
        {
            foreach($bcc as $bccEmailAddress)
            {
                $email->sendBccTo($bccEmailAddress);
            }
        }
        # add Reply To
        if($replyTo) $email->replyTo($replyTo);

        if($email->send())
        {
           return true;
        }
        else
        {
           throw new Exception($email->ErrorInfo);
        }
    }

    public function sendAdminConfirmationEmail()
    {
        $config = App::getConfig('Prijava','email/admin');

        # load data from module config
        $admin      = $config['address'];
        $subject    = $config['subject'];
        $bcc        = $config['bcc'];
        $msg        = $this->_getAdminEmailHtml();

        $email = new Email_Model_Client();

        $email->sendTo($admin);
        $email->setSubject($subject);
        $email->setMessage($msg);

        # add BCC
        if(!empty($bcc))
        {
            foreach($bcc as $bccEmailAddress)
            {
                $email->sendBccTo($bccEmailAddress);
            }
        }

        # attachments
        if(App::getConfig('Prijava','email/admin/attachments/enabled'))
        {
            $docRoot = App::getDocRoot()."/";
            $path = App::getConfig('Prijava','folder/upload');

            # image
            if(App::getConfig('Prijava','email/admin/attachments/image'))
            {
                $image = $path . $this->getImage();
                if(file_exists($docRoot.$image)) $email->addAttachment($image);
            }

            # letter
            $letter = $path . $this->getLetter();
            if(file_exists($docRoot.$letter)) $email->addAttachment($letter);

            # biography
            $biography = $path . $this->getBiography();
            if(file_exists($docRoot.$biography)) $email->addAttachment($biography);

            # supplement
            $supplement = $path . $this->getSupplement();
            if(file_exists($docRoot.$supplement)) $email->addAttachment($supplement);
        }

        if($email->send())
        {
            return true;
        }
        else
        {
            throw new Exception($email->ErrorInfo);
        }

    }

    private function _getAdminEmailHtml()
    {
        $html = "";

        $sectionId = $this->getSection();
        $section = new Prijava_Model_Section();
        $section->load($sectionId);

        $html .= "<p>Prijava za: " . $section->getName();
        $html .= "</p>";

        $html .= "<p><strong>";
        $html .= $this->getName()." ".$this->getLastname()."</strong><br>";
        $html .= $this->getAddress()."<br>";
        $html .= $this->getEmail()."<br>";
        $html .= $this->getPhone()."<br>";
        $html .= "</p>";

        $html .= "<p>";
        $html .= "Završena srednja škola i stečeno zvanje: ".$this->getHighschool()."<br>";
        $html .= "Visokoškolska ustanova (zavšena ili u toku): ".$this->getUniversity()."<br>";
        $html .= "Usmjerenje i izlazno zvanje: ".$this->getTitle()."<br>";
        $html .= "Poznavanje stranih jezika: ".$this->getLanguages()."<br>";
        if($this->getPbp())
        {
            $html .= "Porodica bez prihoda: DA<br>";
        }
        if($this->getCppb())
        {
            $html .= "Član porodice poginulog borca/šehida: DA<br>";
        }
        if($this->getRvi())
        {
            $html .= "Ratni vojni invalid: DA<br>";
        }
        $html .= "</p>";

        return $html;
    }

    public function getImagePath()
    {
        $docRoot = App::getDocRoot()."/";
        $folder = App::getConfig('Prijava','folder/upload');
        $imagePath = $docRoot . $folder . $this->getImage();
        return $imagePath;

    }

    public function getImageUrl()
    {
        $baseUrl = App::getBaseUrl()."/";
        $folder = App::getConfig('Prijava','folder/upload');
        $imageUrl = $baseUrl . $folder . $this->getImage();
        return $imageUrl;
    }

    public function getImagesFolder()
    {
        $docRoot = App::getDocRoot()."/";
        $folder = App::getConfig('Prijava','folder/upload');

        return $docRoot . $folder;
    }

    public function imageResize($width = 600)
    {
        $imageFile = $this->getImagePath();

        try
        {
            $image = new Varien_Image($imageFile);

            $image->open();
            $image->keepAspectRatio(true);
            $image->resize($width);
            $image->save($imageFile);
        }
        catch(Exception $e)
        {
            # todo: add image resize exception to log
            //echo $e->getMessage();
        }

    }

}