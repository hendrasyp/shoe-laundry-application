<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-warning">
			<div class="card-header">
				<h3 class="card-title"><?= $cardTitle; ?></h3>
				<?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<form class="form-horizontal" action="<?= base_url($pageurl) ?>" method="post"
							id="frm_user_filter">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="searchNoFaktur" class="col-sm-3 col-form-label">Invoice Number</label>
								<div class="col-sm-9">
									<input type="text" value="" class="form-control" name="searchNoFaktur"
												 id="searchNoFaktur"
												 placeholder="Invoice Number">
								</div>
							</div>
							<div class="form-group row">
								<label for="searchCustomer" class="col-sm-3 col-form-label">Customer Name</label>
								<div class="col-sm-9">
									<input type="text" value="" class="form-control" name="searchCustomer"
												 id="searchCustomer"
												 placeholder="Customer Name">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="searchStatus" class="col-sm-3 col-form-label">Work Status</label>
								<div class="col-sm-9">
									<select name="searchStatus" id="searchStatus" class="select2 form-control" style="width: 100%">
										<option value="*">All Status</option>
										<option value="0">In Progress</option>
										<option value="1">Packaging</option>
										<option value="2">Done</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="searchPaymentStatus" class="col-sm-3 col-form-label">Payment Status</label>
								<div class="col-sm-9">
									<select name="searchPaymentStatus" id="searchPaymentStatus" class="select2 form-control"
													style="width: 100%">
										<option value="*">All Status</option>
										<option value="0">Unpaid</option>
										<option value="1">Half-Paid</option>
										<option value="2">Paid</option>
									</select>
								</div>
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
				<!--				<h3 class="card-title">Filter</h3>-->
				<div id="" class="card-tools">
					<button type="button" class="btn btn-primary pull-right" id="btn_add_order"> Add Order</button>
					<?php if ($showCleanOrder): ?>
						<button type="button" class="btn btn-danger pull-right" id="btn_clean_order"> Clean Order</button>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-body">

				<div id="" class="col-md-12">
					<table id="grid" style="width: 130%" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th style="width: 5%">No</th>
							<th>Action</th>
							<th>Order No</th>
							<th>Order Date</th>
							<th>Customer</th>
							<th>Payment Status</th>
							<th>Pickup Type</th>
							<th>Status</th>
							<th>Total</th>
							<th>Handle By</th>
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
	var pageBaseUrl = '<?= base_url($pageurl); ?>'
	var gridApiUrl = '<?= base_url($pageurl . '/get_data'); ?>';
</script>
