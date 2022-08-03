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
				<form class="form-horizontal" action="<?= base_url('administration/user') ?>" method="post"
							id="frm_user_filter">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="search_username" class="col-sm-3 col-form-label">Search Name</label>
							<div class="col-sm-9">
								<input type="text" value="<?= $search; ?>" class="form-control" name="search_username"
											 id="search_username"
											 placeholder="Search Username/Name">
							</div>
						</div>
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
			<div class="card-header">
				<div id="" class="card-tools">
					<button type="button" class="btn btn-primary pull-right" id="btn_new_user"> Add New Customer
					</button>
					<button type="button" class="btn btn-info pull-right" id="btn_export"> Export Customer</button>
					<button type="button" class="btn btn-info pull-right" id="btn_export"> Export Customer (All)</button>
					<button type="button" class="btn btn-info pull-right" id="btn_export"> Kirim Notifikasi (> 35 hari)</button>
				</div>
			</div>
			<div class="card-body">

				<div id="" class="col-md-12">
					<table id="gridUser" style="width: 150%" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th style="width: 5%">No</th>
							<th style="width: 8%">Action</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Counter</th>
							<th>Registered Date</th>
							<th>Latest Order</th>
							<th>n Days</th>
							<th>Point</th>
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
<script type="text/javascript">
	var gridUserApiURL = '<?= base_url('administration/customer/get_data'); ?>';
</script>
