<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MX_Controller
{
	private $page_title = "Role";

	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = $this->page_title;
	}

	private $view;

	public function index()
	{
		$this->data['page_title'] = 'Role Management';

		$css = array();
		$js = array('js/modules/role/index.js');
		$search = $this->input->post("search_rolename");
		$this->data['search'] = $search;

		$this->view = $this->viewPage . 'index';
		render_view($this->view, $this->data, $css, $js);
	}

	public function role_get()
	{
		//
		$searchfield = $this->input->post("rolename");
		$args = array();

		if (!empty($searchfield)) {
			$args = array_merge($args, array('name LIKE ' => "%" . $searchfield . "%"));
		}

		$order = $this->input->post("order");
		$dir = $this->input->post("dir");
		$col = 0;
		if (!empty($order)) {
			foreach ($order as $o) {
				$col = $o['column'];
				$dir = $o['dir'];
			}
		}

		if ($dir != "asc" && $dir != "desc") {
			$dir = "desc";
		}
		$valid_columns = array(
			2 => 'name',
			3 => 'description'
		);
		if (!isset($valid_columns[$col])) {
			$order = null;
		} else {
			$order = $valid_columns[$col];
		}

		$no = $_POST['start'];
		$limit = 10;

		if ($_POST['length'] != -1) {
			$limit = $_POST['length'];
		}

		$rowFiltered = $this
			->common_model
			->condition($args)
			->table_name('user_role')
			->orderBy($order)
			->orderDir($dir)
			->limit_offset($limit, $no)
			->do_read();

		$commondb = new Commondb();
		$rowsAll = $commondb->table_name('user_role')
			->condition($args)
			->limit_offset(-1, -1)
			->do_read();

		$data = array();

		foreach ($rowFiltered as $user) {
			$no++;
			$row = array();
			$row[] = $no;

			if ($user->name == 'administrator') {
				$row[] = "";
			} else {
				$row[] = '<a class="btn btn-sm btn-primary" href="' . base_url() . 'administration/user/edit/' . $user->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
          <a class="btn btn-sm btn-danger delete_user" ' . $this->buildDataAttr($user) . ' href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			}


			$row[] = $user->name;
			$row[] = $user->description;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => sizeof($rowsAll),
			"recordsFiltered" => sizeof($rowFiltered),
			"data" => $data,
		);
		//$this->output->enable_profiler(TRUE);
		echo json_encode($output);
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
		$data = $this
			->common_model
			->condition(array('id' => $id))
			->table_name(V_USER_ROLE)
			->do_read();
		$commondb = new Commondb();

		$roleList = $commondb
			->table_name("user_role")
			->limit_offset(-1, 0)
			->do_read();

		$this->view = $this->viewPage . 'edit';
		$this->data['viewData'] = $data[0];
		$this->data['roleList'] = $roleList;
		$css = array();
		$js = array('js/modules/user/edit.js');
		render_view($this->view, $this->data, $css, $js);
	}

	public function add()
	{
		$this->view = $this->viewPage . 'add';
		$css = array();
		$js = array('js/modules/role/edit.js');
		render_view($this->view, $this->data, $css, $js);
	}

	public function insert()
	{
		$input = $this->input->post();
		$toInsert = array(
			'name' => $input['rolename'],
			'description' => $input['description']
		);

		$update = $this
			->common_model
			->table_name('user_role')
			->data_request($toInsert)
			->do_insert();

		$response = array('message' => 'success');
		if ($update == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat simpan.');
		}
		echo json_encode($response);
	}

	public function update()
	{
		$input = $this->input->post();
		$toUpdate = array(
			'name' => $input['name'],
			'role_id' => $input['roleid'],
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
