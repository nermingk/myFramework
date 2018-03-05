<?php
class Prijava_SectionController extends Core_Controller_Abstract
{
    protected $page;

    /**
     * Prijava_SectionController constructor.
     */
    public function __construct()
    {
        die('Access denied.');

        # set default layout for this controller
        $this->page = $this->getLayout('prijava/layout/default');
    }

    public function indexAction()
    {
        $collection = new Prijava_Model_Section_Collection();
        $collection->loadResults();


        $view = new Prijava_View_Section_Index();
        $view->setItems($collection->getItems());

        $this->page->setContent($view)->render();
    }

    public function addAction()
    {

        //$view = new Prijava_View_Section_Add();
        $view = new Core_View_Default();
        $view->setTemplate('prijava/section/add.phtml');
        $view->setTitle("Section/Add");

        $this->page->setContent($view)->render();
    }
    public function addPostAction()
    {
        $name = $_POST['name'];
        $section = new Prijava_Model_Section();
        $section->setName($name);
        $section->save();
        $this->redirect('/prijava/section');
    }
    public function editAction($id = "")
    {
        $section = new Prijava_Model_Section();
        $section->load($id);

        $view = new Prijava_View_Section_Edit();
        $view->setItem($section);



        $page = $this->getLayout();
        $page->setContent($view);
        $page->render();
    }
    public function editPostAction()
    {
        $section = new Prijava_Model_Section();
        $section->load($_POST['id']);
        $section->setData($_POST);
        $section->save();
        $this->redirect('/prijava/section');
    }


}