<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-warning collapsed-card">
			<div class="card-header">
				<h3 class="card-title"><?= $cardTitle; ?></h3>
				<?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<form class="form-horizontal " action="<?= base_url($pageurl) ?>" method="post"
							id="frm_user_filter">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="searchNoFaktur" class="col-sm-3 col-form-label">Invoice Number</label>
								<div class="col-sm-9">
									<input type="text" value="" class="form-control form-control-sm" name="searchNoFaktur"
												 id="searchNoFaktur"
												 placeholder="Invoice Number">
								</div>
							</div>
							<div class="form-group row">
								<label for="searchCustomer" class="col-sm-3 col-form-label">Customer Name</label>
								<div class="col-sm-9">
									<input type="text" value="" class="form-control form-control-sm" name="searchCustomer"
												 id="searchCustomer"
												 placeholder="Customer Name">
								</div>
							</div>
							<div class="form-group row">
								<label for="searchDateRange" class="col-sm-3 col-form-label">Period</label>
								<div class="col-sm-9">
									<div class="input-group">
										<div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
										</div>
										<input type="text" name="reservation" class="form-control form-control-sm float-right"
													 id="reservation">
									</div>
								</div>

								<!-- /.input group -->
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="searchStatus" class="col-sm-3 col-form-label">Work Status</label>
								<div class="col-sm-9">
									<select name="searchStatus" id="searchStatus" class="select2 form-control form-control-sm"
													style="width: 100%">
										<option value="*">All Status</option>
										<option value="IN PROGRESS">In Progress</option>
										<option value="READY TO PICKUP">Ready To Pickup</option>
										<option value="CLOSED">CLOSED</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="searchPaymentStatus" class="col-sm-3 col-form-label">Payment Status</label>
								<div class="col-sm-9">
									<select name="searchPaymentStatus" id="searchPaymentStatus"
													class="select2 form-control form-control-sm"
													style="width: 100%">
										<option value="*">All Status</option>
										<option value="UNPAID">Unpaid</option>
										<option value="HALF-PAID">Half-Paid</option>
										<option value="PAID">Paid</option>
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

			<div class="card-body">
				<div class="col-md-12">
					<table style="width: 100%" class="table table-bordered table-striped table-sm">
						<tbody>

						<tr>
							<td>Total Belum dibayar (Kasbonan)</td>
							<td>:</td>
							<td style="text-align: right">Rp. <span id="totalKasbonan"> </span></td>
						</tr>

						<tr>
							<td>Total yang sudah dibayar (Lunas)</td>
							<td>:</td>
							<td style="text-align: right">Rp. <span id="totalPaid"> </span></td>
						</tr>

						<tr>
							<td>Total uang muka (DP)</td>
							<td>:</td>
							<td style="text-align: right">Rp. <span id="totalDp"> </span></td>
						</tr>

						<tr style="">
							<td>Total uang yang sudah masuk</td>
							<td data-ng-style="">:</td>
							<td style="text-align: right">Rp. <span id="totalOrder"> </span></td>
						</tr>

						<tr style="">
							<td>Total pemasukan yang seharunya didapat (saat semua sudah Lunas)</td>
							<td>:</td>
							<td style="text-align: right">Rp. <span id="totalSemua"> </span></td>
						</tr>

						</tbody>
					</table>
				</div>

				<div id="" class="col-md-12">
					<table id="grid" style="width: 140%" class="table table-bordered table-striped table-sm">
						<thead>
						<tr>
							<th style="width: 5%">No</th>
							<th style="width: 15%">Order No</th>
							<th>Order Date</th>
							<th>Customer</th>
							<th>Total Shoes</th>
							<th>Down Payment</th>
							<th>Total Order</th>
							<th>Payment Status</th>
							<th>Status</th>
							<th>Employee</th>
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
