<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends MX_Controller {

    private $view;
    private $userInfo;
    private $pageUrl;

    public function __construct() {
        parent::__construct();
        $this->data['page_title'] = 'Service Management';
        $this->userInfo = $this->userInfo();
        $this->userInfo = $this->userInfo["user"];
        $this->load->model('Mservice');
        $this->data['pageurl'] = 'administration/service';
        $this->pageUrl = $this->data['pageurl'];
    }

    public function searchField($search, $operator = "AND") {
        $where = array();
        // $where[] = "isbranch = 'YES' ";
        foreach ($search as $k => $v) {
            if (!empty($v)) {
                $where[] = " " . $k . " LIKE '%" . $v . "%' ";
            }
        }
        return implode($operator, $where);
    }

    public function get_data() {
        $cSearch = array(
          "typename" => $this->input->post("searchByName")
        );

        $where = $this->searchField($cSearch);

        $list = $this->Mservice->get_datatables($where);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url() . $this->pageUrl . '/edit/' . $field->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
          <a class="btn btn-sm btn-danger delete_service" ' . $this->buildDataAttr($field) . ' href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $row[] = $field->typename;
            $row[] = $field->typeprice;
            $row[] = $field->isextra;
            $row[] = $field->typedescription;

            $data[] = $row;
        }

        $output = array(
          "draw" => $_POST['draw'],
          "recordsTotal" => $this->Mservice->count_all(),
          "recordsFiltered" => $this->Mservice->count_filtered($where),
          "data" => $data,
        );
        echo json_encode($output);
    }

    public function index() {
        $css = array();
        $js = array('js/modules/service/index.js');

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

    public function edit($id) {
        $commondb = new Commondb();
        $data = $this
            ->common_model
            ->condition(array('id' => $id))
            ->table_name(V_SERVICE)
            ->do_read();


        $this->view = $this->viewPage . 'edit';
        $this->data['viewData'] = $data[0];
        $css = array();
        $js = array('js/modules/service/edit.js');
        render_view($this->view, $this->data, $css, $js);
    }

    public function add() {
        $commondb = new Commondb();
        $id = null;
        $data = $this
            ->common_model
            ->condition(array('id' => $id))
            ->table_name(TABLE_SERVICE)
            ->do_read();


        $this->view = $this->viewPage . 'add';
        $this->data['viewData'] = $data;
        $css = array();
        $js = array('js/modules/service/edit.js');
        render_view($this->view, $this->data, $css, $js);
    }

    public function insert() {
        $input = $this->input->post();
        $toInsert = array(
          'typename' => $input['txtName'],
          'typeprice' => $input['txtPrice'],
          'isextra' => $input['cboIsExtra'],
          'point' => $input['txtPoint'],
          'typedescription' => $input['txtDescription'],
          'estimate_day' => $input['txtEstimate']
        );

        $update = $this
            ->common_model
            ->table_name(TABLE_SERVICE)
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
          'typename' => $input['txtName'],
          'typeprice' => $input['txtPrice'],
          'isextra' => $input['cboIsExtra'],
          'point' => $input['txtPoint'],
          'typedescription' => $input['txtDescription'],
			'estimate_day' => $input['txtEstimate']
        );

        $update = $this
            ->common_model
            ->table_name(TABLE_SERVICE)
            ->condition(array('id' => $input['txtServiceId']))
            ->data_request($toInsert)
            ->do_update();

        $response = array('message' => 'success');
        if ($update == false) {
            $response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
        }
        echo json_encode($response);
    }

    public function delete($id) {
        $args = array(
          'id' => $id
        );

        $delete = $this
            ->common_model
            ->condition($args)
            ->table_name(TABLE_SERVICE)
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

}
