<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Branch extends MX_Controller {

    private $view;
    private $userInfo;
    private $pageUrl;

    public function __construct() {
        parent::__construct();
        $this->data['page_title'] = 'Company Management';
        $this->userInfo = $this->userInfo()["user"];
        $this->load->model('Mcounter');
        $this->data['pageurl'] = 'administration/company';
        $this->pageUrl = $this->data['pageurl'];
    }

    public function index() {
        
    }
    public function profile() {
        $commondb = new Commondb();
        $data = $this
            ->common_model
            ->condition(array('id' => $this->userInfo->counterid))
            ->table_name(TABLE_COUNTER_LOCATION)
            ->do_read();

        $this->data['viewData'] = $data[0];
        //do_debug($this->userInfo->counterid);
        //do_debug($this->data['viewData']);
        $this->view = $this->viewPage . 'edit';
        $css = array();
        $js = array('js/modules/branch/edit.js');
        render_view($this->view, $this->data, $css, $js);
    }

    public function update() {
        $input = $this->input->post();
        do_debug($input, true);

        $toInsert = array(
          'name' => $input['txtName'],
          'address' => $input['txtAddress'],
          'phone' => $input['txtPhone'],
          'email' => $input['txtEmail'],
          'mapurl' => $input['txtGoogleMap'],
          'contact_person' => $input['txtContactPerson']
        );

        $update = $this
            ->common_model
            ->table_name(TABLE_COUNTER_LOCATION)
            ->condition(array('id' => $input['txtCompanyId']))
            ->data_request($toInsert)
            ->do_update();

        $response = array('message' => 'success');
        if ($update == false) {
            $response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
        }
        echo json_encode($response);


    }

}
