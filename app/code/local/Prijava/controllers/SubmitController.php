<?php
class Prijava_SubmitController extends Core_Controller_Abstract
{
    private $imageFiles = array('jpg','jpeg','png');
    private $docFiles = array('doc','docx','pdf');

    public function indexAction()
    {
        if(!isset($_POST['formkey']) or !App::isValidKey($_POST['formkey'])) die("Access denied!");

        $ERROR = false;
        $errorMsg = "";

        $post = new Varien_Object();
        $post->setData($_POST);


        $post->unsetData('formkey');
        # add data to session to be used if wrong file format is selected
        $_SESSION['prijava'] = $post->getData();


            # check if image is selected
            if($_FILES['image']['name'])
            {
                $image = new Varien_File_Uploader($_FILES['image']);
            }
            else
            {
                $_SESSION['error'] = "Molimo Vas da dodate fotografiju";
                $this->redirect('/prijava');
            }

            # check if letter is selected
            if($_FILES['letter']['name'])
            {
                $letter = new Varien_File_Uploader($_FILES['letter']);
            }
            else
            {
                $_SESSION['error'] = "Molimo Vas da dodate motivaciono pismo";
                $this->redirect('/prijava');
            }

            # check if biography is selected
            if($_FILES['biography']['name'])
            {
                $biography = new Varien_File_Uploader($_FILES['biography']);
            }
            else
            {
                $_SESSION['error'] = "Molimo Vas da dodate biografiju";
                $this->redirect('/prijava');
            }

            if($_FILES['supplement']['name']) $supplement = new Varien_File_Uploader($_FILES['supplement']);

            if(!in_array(strtolower($image->getFileExtension()),$this->imageFiles))
            {
                $ERROR = true;
                $errorMsg = "Molimo Vas da dodate fotografiju u jednom od formata: 'jpg','jpeg' ili 'png'";
            }
            elseif(!in_array(strtolower($letter->getFileExtension()),$this->docFiles))
            {
                $ERROR = true;
                $errorMsg = "Molimo Vas da dodate Motivaciono pismo u jednom od formata: 'doc','docx' ili 'pdf'";
            }
            elseif(!in_array(strtolower($biography->getFileExtension()),$this->docFiles))
            {
                $ERROR = true;
                $errorMsg = "Molimo Vas da dodate Biografiju u jednom od formata: 'doc','docx' ili 'pdf'";
            }
            elseif($_FILES['supplement']['name'] and !in_array(strtolower($supplement->getFileExtension()),$this->docFiles))
            {
                $ERROR = true;
                $errorMsg = "Molimo Vas da izaberete Dodatak u jednom od formata: 'doc','docx' ili 'pdf'";
            }

        # go back to form
        if($ERROR)
        {
            $_SESSION['error'] = $errorMsg;
            $this->redirect('/prijava');
        }

        ############################################################
        # SAVE DATA (without files data)
        $person = new Prijava_Model_Person();
        $person->setData($post->getData());

        # add date
        $date = new DateTime();
        $person->setDate($date->format('Y-m-d'));


        $person->save();

        # GET NEW ID
        $id = $person->getId();

        ###########################################################
        # UPLOAD FILES

        # create prefix for file names
        $filePrefix = $post->getName()."_".$post->getLastname()."_";
        $filePrefix = $id."_".$this->_getValidString($filePrefix);

        # todo: check and autocrete path folder
        $path = App::getConfig('Prijava','folder/upload');

        # upload image
        $imageFileName = $filePrefix."_photo.".$image->getFileExtension();
        $image->save($path,$imageFileName);

        $person->setImage($imageFileName);


        # upload letter
        $letterFileName = $filePrefix."_motiv_pismo.".$letter->getFileExtension();
        $letter->save($path, $letterFileName);

        $person->setLetter($letterFileName);

        # upload biography
        $biographyFileName = $filePrefix."_biografija.".$biography->getFileExtension();
        $biography->save($path,$biographyFileName);

        $person->setBiography($biographyFileName);

        # upload supplement
        if($_FILES['supplement']['name'])
        {
            $supplementFileName = $filePrefix."_dodatak.".$supplement->getFileExtension();
            $supplement->save($path,$supplementFileName);

            $person->setSupplement($supplementFileName);
        }

        # unset session data
        if(isset($_SESSION['prijava'])) unset($_SESSION['prijava']);
        if(isset($_SESSION['error'])) unset($_SESSION['error']);


        # SAVE FILE NAMES
        $person->save();

        # RESIZE IMAGE
        if(App::getConfig('Prijava','file/image/resize'))
        {
            $person->imageResize(600);
        }

        # SEND CONFIRMATION EMAILS
        try
        {
            # send email to subscriber
            $emailSent = $person->sendConfirmationEmail();
            if($emailSent)
            {
                $person->setEmailSent(1);
                $person->save();

            }
            # send email to admin
            $person->sendAdminConfirmationEmail();
        }
        catch(Exception $e)
        {
            $logData = array(
                'person_id' => $person->getId(),
                'error' => 'error in sending confirmation email',
                'error_msg' => $e->getMessage()
            );

            # todo: log email sending exception
        }

        $this->redirect('/prijava/index/success');
    }

    private function _getValidString($string)
    {
        $toReplace = array('č','ć','š','ž','đ','Č','Ć','Š','Ž','Đ');
        $replaceWith = array('c','c','s','z','dj','c','c','s','z','dj');
        $validString = str_replace($toReplace,$replaceWith,$string);

        $validString = preg_replace('/\s+/', '', $validString);

        return strtolower($validString);
    }


}