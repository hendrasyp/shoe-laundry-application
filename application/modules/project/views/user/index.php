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
							<label for="search_username" class="col-sm-3 col-form-label">Email</label>
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
				<h3 class="card-title">Primary Outline</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					</button>
				</div>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">

				<table id="grid" style="width: 100%" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th style="width: 5%">No</th>
						<th style="width: 15%">Action</th>
						<th style="width: 30%">Author</th>
						<th style="width: 30%">Title</th>
						<th style="width: 20%">Categories</th>
					</tr>
					</thead>
					<tbody>

					</tbody>
				</table>

			</div>
			<!-- /.card-body -->
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-warning">
			<div class="card-header">
				<h3 class="card-title">Primary Outline</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					</button>
				</div>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				The body of the card
			</div>
			<!-- /.card-body -->
		</div>
	</div>
</div>
