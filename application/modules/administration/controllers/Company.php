<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends MX_Controller {

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

    public function searchField($search, $operator = "AND") {
        $where = array();
        $where[] = "isbranch = 'YES' ";
        foreach ($search as $k => $v) {
            if (!empty($v)) {
                $where[] = " " . $k . " LIKE '%" . $v . "%' ";
            }
        }
        return implode($operator, $where);
    }

    public function get_data() {
        $cSearch = array(
          "name" => $this->input->post("searchByName"),
          "name" => $this->input->post("searchByName"),
          "address" => $this->input->post("searchByAddress"),
          "email" => $this->input->post("searchByEmail"),
          "phone" => $this->input->post("searchByPhone"),
        );

        $where = $this->searchField($cSearch);

        $list = $this->Mcounter->get_datatables($where);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url() . $this->pageUrl . '/edit/' . $field->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
          <a class="btn btn-sm btn-danger delete_branch" ' . $this->buildDataAttr($field) . ' href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $row[] = $field->name;
            $row[] = $field->address;
            $row[] = $field->phone;
            $row[] = $field->email;
            $row[] = $field->isbranch;
            $row[] = $field->cp;

            $data[] = $row;
        }

        $output = array(
          "draw" => $_POST['draw'],
          "recordsTotal" => $this->Mcounter->count_all(),
          "recordsFiltered" => $this->Mcounter->count_filtered($where),
          "data" => $data,
        );
        echo json_encode($output);
    }

    public function index() {
        $this->data['page_title'] = 'Company Management';

        $css = array();
        $js = array('js/modules/company/index.js');

        $this->view = $this->viewPage . 'index';
        render_view($this->view, $this->data, $css, $js);
    }

    public function buildDataAttr($arr) {
        $data_attribute = "";
        foreach ($arr as $key => $value) {
            $data_attribute .= ' data-' . $key . '="' . $value . '" ';
        }
        return $data_attribute;
    }

    public function delete($id) {
        $args = array(
          'id' => $id
        );

        $delete = $this
            ->common_model
            ->condition($args)
            ->table_name(T_USER)
            ->do_delete();
        $return = array(
          'message' => 'success',
          'message_detail' => 'success',
        );
        if ($delete == false) {
            $return = array(
              'message' => 'error',
              'message_detail' => 'Tidak bisa menghapus user',
            );
        }
        echo json_encode($return);
    }

    public function edit($id) {
        $commondb = new Commondb();
        $data = $this
            ->common_model
            ->condition(array('id' => $id))
            ->table_name(TABLE_COUNTER_LOCATION)
            ->do_read();


        $this->view = $this->viewPage . 'edit';
        $this->data['viewData'] = $data[0];
        $css = array();
        $js = array('js/modules/company/edit.js');
        render_view($this->view, $this->data, $css, $js);
    }

    public function add() {
        $commondb = new Commondb();
        $id = null;
        $data = $this
            ->common_model
            ->condition(array('id' => $id))
            ->table_name(TABLE_COUNTER_LOCATION)
            ->do_read();


        $this->view = $this->viewPage . 'add';
        $this->data['viewData'] = $data;
        $css = array();
        $js = array('js/modules/company/edit.js');
        render_view($this->view, $this->data, $css, $js);
    }

    public function insert() {
        $input = $this->input->post();
        $toInsert = array(
          'name' => $input['txtName'],
          'address' => $input['txtAddress'],
          'phone' => $input['txtPhone'],
          'email' => $input['txtEmail'],
          'mapurl' => $input['txtGoogleMap'],
          'isbranch' => $input['cboIsBranch'],
          'contact_person' => $input['txtContactPerson']
        );

        $update = $this
            ->common_model
            ->table_name(TABLE_COUNTER_LOCATION)
            ->data_request($toInsert)
            ->do_insert();

        $response = array('message' => 'success');
        if ($update == false) {
            $response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
        }
        echo json_encode($response);
    }

    public function update() {
        $input = $this->input->post();
        $toInsert = array(
          'name' => $input['txtName'],
          'address' => $input['txtAddress'],
          'phone' => $input['txtPhone'],
          'email' => $input['txtEmail'],
          'mapurl' => $input['txtGoogleMap'],
          'isbranch' => $input['cboIsBranch'],
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
