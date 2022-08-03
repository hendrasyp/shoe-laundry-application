<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-warning">
			<div class="card-header">
				<h3 class="card-title">Filter</h3>
				<?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<form class="form-horizontal" action="<?= base_url('administration/role') ?>" method="post"
					  id="frm_role_filter">
					<div class="col-md-6">
						<?php
						usercontrol('input_text',array('param' => array(
								'id' => 'search_rolename',
								'label' => 'Search Role Name',
							'value'=>$search

						)));
						?>
					</div>
				</form>
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				<div class="row-cols-md-6">
					<button type="button" class="btn btn-primary" id="btn_search">Search</button>
					<button type="button" class="btn btn-default btn-outline-info" id="btn_search_clear">Clear</button>
				</div>
			</div>
			<!-- /.card-footer -->

		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-warning">
			<!-- /.card-header -->
			<div class="card-body">
				<div id="" class="col-md-12">
					<button type="button" class="btn btn-primary" id="btn_new_role"> Add New Role </button>
				</div>
				<div id="" class="col-md-12">
					<table id="grid" style="width: 100%" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th style="width: 5%">No</th>
							<th style="width: 15%">Action</th>
							<th style="width: 30%">Fullname</th>
							<th style="width: 30%">Username</th>
						</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>



			</div>
			<!-- /.card-body -->
		</div>
	</div>
</div>
