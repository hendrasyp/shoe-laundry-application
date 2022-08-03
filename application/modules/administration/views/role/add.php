<?php

?>
<form class="form-horizontal" id="frm_role_detail" name="frm_role_detail" method="post">
	<input type="hidden" name="hid_role_id" id="hid_role_id" value="0">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-outline card-warning">
				<div class="card-header">
					<h3 class="card-title">Role Detail</h3>
					<?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
					<!-- /.card-tools -->
				</div>
				<div class="card-body">
					<div class="col-md-6">
						<?php
						usercontrol('input_text',array('param' => array(
								'id' => 'rolename',
								'label' => 'Role Name',
								'placeholder' => 'Role Name',

						)));
						usercontrol('input_text',array('param' => array(
								'id' => 'description',
								'label' => 'Description',
								'placeholder' => 'Description',

						)));
						?>
					</div>

				</div>
				<div class="card-footer">
					<button type="button" id="btn_save" class="btn btn-success">Save</button>
					<button type="button" class="btn btn-default">Cancel</button>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
</form>
