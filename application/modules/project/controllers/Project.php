<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project extends MX_Controller
{
    private $page_title = "Product";

    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = $this->page_title;
    }

    public function index()
    {

    }

}
