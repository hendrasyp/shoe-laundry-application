<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class Customer extends MX_Controller
{

	private $view;
	private $userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->userInfo = $this->userInfo();
		$this->userInfo = $this->userInfo["user"];
		$this->data['page_title'] = 'Customer Management';
		$this->load->model('Mvuserlist');
	}

	function change_password()
	{
		$this->data['page_title'] = "Change Password";
		$id = $this->userInfo->id;
		$data = $this
			->common_model
			->condition(array('id' => $id))
			->table_name(V_USER_LIST)
			->do_read();
		$commondb = new Commondb();

		$roleList = $commondb
			->table_name("user_role")
			->limit_offset(-1, 0)
			->do_read();

		$this->view = $this->viewPage . 'change_password';
		$this->data['viewData'] = $data[0];
		//do_debug($this->data['viewData']);
		$this->data['roleList'] = $roleList;
		$css = array();
		$js = array('js/modules/user/edit.js');
		render_view($this->view, $this->data, $css, $js);
	}

	function get_data()
	{
		$customSearch = $this->input->post('searchByName');
		$list = null;
		$where = null;

		if (isset($customSearch) && $customSearch != "") {
			$where = "roleid = 2 AND name LIKE '%" . $customSearch . "%' OR phone LIKE '%" . $customSearch . "%'";
		} else {
			$where = "roleid = 99";
		}

		$list = $this->Mvuserlist->get_datatables($where);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$btnEdit = array(
				"class" => "btn-sm btn-primary",
				"href" => base_url() . 'administration/customer/edit/' . $field->id,
				"title" => "",
				"icon" => "fas fa-edit",
				"attr" => $this->buildDataAttr($field)
			);
			$btnAddOrder = array(
				"class" => "btn-sm btn-info btn_user_add_order",
				"href" => "javascript:void(0)", //base_url() . 'transaction/order/add_customer/' . $field->id,
				"title" => "",
				"icon" => "fa-cart-plus",
				"attr" => $this->buildDataAttr($field)
			);
			$btnDelete = array(
				"class" => "btn-sm btn-danger delete_user",
				"href" => "javascript:void(0)",
				"title" => "",
				"icon" => "fa-trash",
				"attr" => $this->buildDataAttr($field)
			);
			$no++;
			$row = array();
			$row[] = $no;
//            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url() . 'administration/user/edit/' . $field->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
//          <a class="btn btn-sm btn-danger delete_user" ' . $this->buildDataAttr($field) . ' href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$row[] = renderActionButton($btnEdit) . ' ' . renderActionButton($btnAddOrder) . ' ' . renderActionButton($btnDelete);
			$row[] = ucwords(strtolower($field->name));
			$row[] = $field->phone;
			$row[] = $field->email;
			$row[] = $field->counter;
			$row[] = formatDate(DT_FORMAT_FOR_STR, $field->registered_date);
			$row[] = formatDate(DT_FORMAT_FOR_STR, $field->latest_order_date);
			$row[] = $field->selisih_hari;
			$row[] = $field->jumlah_point;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Mvuserlist->count_all($where),
			"recordsFiltered" => $this->Mvuserlist->count_filtered($where),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function index()
	{
		$css = array();
		$js = array('js/modules/customer/index.js');
		$search = $this->input->post("search_username");
		$this->data['search'] = $search;

		$this->view = $this->viewPage . 'index';
		render_view($this->view, $this->data, $css, $js);
	}

	public function buildDataAttr($arr)
	{
		$data_attribute = "";
		foreach ($arr as $key => $value) {
			$data_attribute .= ' data-' . $key . '="' . $value . '" ';
		}
		return $data_attribute;
	}

	public function delete($id)
	{
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

	public function edit($id)
	{
		//print_r($this->userInfo);

		$data = $this
			->common_model
			->condition(array('id' => $id))
			->table_name(V_USER_LIST)
			->do_read();
		$commondb = new Commondb();

		$roleList = $commondb
			->table_name("user_role")
			->limit_offset(-1, 0)
			->do_read();

		$this->view = $this->viewPage . 'edit';
		$this->data['viewData'] = $data[0];
		//do_debug($this->data['viewData']);
		$this->data['roleList'] = $roleList;
		$css = array();
		$js = array('js/modules/customer/edit.js');
		render_view($this->view, $this->data, $css, $js);
	}

	public function add()
	{
		$commondb = new Commondb();

		$roleList = $commondb
			->table_name("user_role")
			->limit_offset(-1, 0)
			->do_read();

		$this->view = $this->viewPage . 'add';
		$this->data['roleList'] = $roleList;
		$css = array();
		$js = array('js/modules/customer/edit.js');
		render_view($this->view, $this->data, $css, $js);
	}

	public function insert()
	{
		$input = $this->input->post();
		$toInsert = array(
			'name' => $input['name'],
			'username' => $input['username'],
			'phone' => $input['phone'],
			'email' => $input['email'],
			'created_date' => dateToday(),
			'password' => md5($input['password']),
			'role_id' => 2,
			'counter_id' => $this->userData->counterid
		);

		$update = $this
			->common_model
			->table_name('user')
			->data_request($toInsert)
			->do_insert();

		$response = array('message' => 'success');
		if ($update == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function update()
	{
		$input = $this->input->post();
		$toUpdate = array(
			'name' => $input['name'],
			'username' => $input['username'],
			'phone' => $input['phone'],
			'email' => $input['email'],
			'role_id' => 2,
			'counter_id' => $this->userData->counterid
		);

		if (!empty($input['password'])) {
			$toUpdate = array_merge($toUpdate, array('password' => md5($input['password'])));
		}

		$update = $this
			->common_model
			->table_name('user')
			->data_request($toUpdate)->condition(array('id' => $input['hid_user_id']))->do_update();

		$response = array('message' => 'success');
		if ($update == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

}
