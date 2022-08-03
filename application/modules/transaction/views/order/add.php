<form class="form-horizontal" id="frm_input" name="frm_input" method="post">
	<input type="hidden" class="form-control form-control-sm" name="orderId" id="orderId">

	<div class="row">
		<div class="col-md-3" style="float: left">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-outline card-warning">
						<div class="card-header">
							<h3 class="card-title">Order Info</h3>
							<?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
							<!-- /.card-tools -->
						</div>
						<div class="card-body">
							<div class="col-sm-12">
								<div class="form-group row">
									<label for="orderNo" class="col-sm-4 col-form-label">Order No</label>
									<div class="col-sm-8">
										<input type="hidden" readonly="readonly" class="form-control form-control-sm"
													 name="order_id"
													 value="<?php echo isset($orderData) ? $orderData['header']['id'] : ""; ?>"
													 id="order_id">
										<input type="text"
													 readonly="readonly"
													 value="<?php echo isset($orderData) ? $orderData['header']['order_no'] : $noFaktur; ?>"
													 class="form-control form-control-sm"
													 name="orderNo"
													 id="orderNo"
													 placeholder="Branch Name">
									</div>
								</div>
								<div class="form-group row">
									<label for="orderDate" class="col-sm-4 col-form-label">Order Date</label>
									<div class="col-sm-8">
										<div class="input-group date">

											<input readonly="readonly" style="text-align: center"
														 value="<?php echo isset($orderData) ? formatDate(DT_FORMAT_FOR_STR, $orderData['header']['order_date']) : dateToday('d/m/Y'); ?>"
														 id="orderDate" title="Please Select Date" type="text"
														 class="form-control form-control-sm pull-right datepicker">

										</div>


									</div>
								</div>
								<div class="form-group row">
									<label for="orderFinishDate" class="col-sm-4 col-form-label">Finish Date
										<em>(Estimate)</em></label>
									<div class="col-sm-8">
										<div class="input-group date">
											<?php
											$estimateDate = isset($orderData) ? $orderData['header']['order_date'] : dateToday();
											if (isset($orderData)) {
												if ($orderData['header']['finish_date_estimation'] != "") {
													$estimateDate = $orderData['header']['finish_date_estimation'];
												}
											}
											$estimateDate = formatDate(DT_FORMAT_FOR_STR, $estimateDate);
											?>
											<input style="text-align: center"
														 value="<?php echo $estimateDate; ?>"
														 id="orderFinishDate" readonly="readonly" title="Please Select Date"
														 type="text"
														 class="form-control form-control-sm pull-right datepicker">
										</div>


									</div>
								</div>
								<div class="form-group row">
									<label for="counterLocation" class="col-sm-4 col-form-label">Branch</label>
									<div class="col-sm-8">
										<input type="text"
													 value="<?php echo isset($orderData) ? $orderData['header']['order_location'] : $loginInfo->counter; ?>"
													 class="form-control form-control-sm"
													 name="counterLocation" id="counterLocation" readonly="readonly"
													 placeholder="">
									</div>
								</div>
							</div>
						</div>

						<!-- /.card-body -->
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card card-outline card-warning">
						<div class="card-header">
							<h3 class="card-title">Customer Info</h3>
							<?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
							<!-- /.card-tools -->
						</div>
						<div class="card-body">


							<div class="col-sm-12">
								<div class="form-group row">
									<label for="txtCustomerName" class="col-sm-3 col-form-label">Name</label>
									<div class="col-sm-9">
										<div class="input-group mb-3" style="margin-bottom: 0rem !important;">
											<input type="hidden" id="txtCustomerID"
														 value="<?php echo isset($orderData) ? $orderData['header']['cust_id'] : '' ?>"
														 name="txtCustomerID"
														 class="form-control form-control-sm">
											<input type="text" readonly="readonly" id="txtCustomerName"
														 value="<?php echo isset($orderData) ? $orderData['header']['cust_name'] : '' ?>"
														 name="txtCustomerName"
														 class="form-control form-control-sm">
											<div class="input-group-prepend">
												<button type="button" id="btnSearchCustomer"
																class="btn btn-danger btn-sm"><i
															class="fa fa-search"></i></button>
											</div>
											<!-- /btn-group -->
										</div>

									</div>
								</div>
								<div class="form-group row">
									<label for="txtCustomerPhone" class="col-sm-3 col-form-label">Phone</label>
									<div class="col-sm-9">
										<input type="text" id="txtCustomerPhone" readonly="readonly"
													 value="<?php echo isset($orderData) ? addZeroToPhone($orderData['header']['phone'])  : ''; ?>"
													 name="txtCustomerPhone"
													 class="form-control form-control-sm">
									</div>
								</div>
								<div class="form-group row">
									<label for="txtCustomerEmail" class="col-sm-3 col-form-label">Email</label>
									<div class="col-sm-9">
										<input type="text" id="txtCustomerEmail" readonly="readonly"
													 value="<?php echo isset($orderData) ? $orderData['header']['email'] : '' ?>"
													 name="txtCustomerEmail"
													 class="form-control form-control-sm">
									</div>
								</div>

							</div>

						</div>
						<!-- /.card-body -->
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9" style="float: left">
			<div class="card card-outline card-warning">
				<div class="card-body">
					<div class="col-sm-6" style="float: left;">
						<div class="form-group row">
							<label for="cboChangeStatus" class="col-sm-5 col-form-label">Current Work Status</label>
							<label for="cboChangeStatus"
									<?php
									$tStatus = "In Progress";
									if (isset($orderData)) {
										if (($orderData["header"]["order_status_id"] == 2) && ($orderData["header"]["pickup_date"] == "")) {
											$tStatus = "Finished";
										} elseif (($orderData["header"]["order_status_id"] == 2) && ($orderData["header"]["pickup_date"] != "")) {
											$tStatus = "Finish. Picked up at " . formatDate("d F Y", $orderData["header"]["pickup_date"]);
										}
									}
									?>
										 class="col-sm-7 col-form-label"><strong><?= $tStatus; ?></strong></label>

						</div>
					</div>
					<div class="col-sm-6" style="float: left;text-align: right">
						<?php
						$showFinish = false;
						$showPickup = false;
						if (isset($orderData)) {
							if ($orderData["header"]["order_status_id"] != "2") {
								$showFinish = true;
							} else {
								if ($orderData["header"]["order_status_id"] == "2" && $orderData["header"]["pickup_date"] == "") {
									$showPickup = true;

								} else if ($orderData["header"]["order_status_id"] == "2" && $orderData["header"]["pickup_date"] != "") {
									$showPickup = false;

								}
							}
						} else {
							$showFinish = true;
						}
						?>
						<?php if ($showFinish): ?>
							<button type="button" class="btn btn-primary btn_finish_order">Finish Order</button>
						<?php else: ?>
							<?php if ($showPickup): ?>
								<button type="button" class="btn btn-primary btn_pick_order">Pick Up !!</button>
							<?php endif; ?>
						<?php endif; ?>
						<button type="button" class="btn btn-default btn_cancel">Cancel</button>
					</div>

				</div>
			</div>
			<div class="card card-outline card-warning">
				<div class="card-header">
					<h3 class="card-title">Order Detail</h3>
					<div class="card-tools">
						<?php
						$showAddServiceButton = false;
						if (isset($orderData)) {
							if ($orderData["header"]["payment_status_id"] == 0 || $orderData["header"]["payment_status_id"] == 1) {
								$showAddServiceButton = true;
							}
						} else {
							$showAddServiceButton = true;
						}

						?>
						<?php if ($showAddServiceButton): ?>
							<button type="button" class="btn btn-primary btn-sm" id="btn_add_service"><i
										class="fa fa-plus-square"></i> Add Service
							</button>
						<?php endif; ?>
					</div>
					<!-- /.card-tools -->
				</div>
				<div class="card-body table-responsive p-0" style="height: 100%;">
					<?php
					$total = 0;
					$extraTotal = 0;
					$estimateDay = 0;
					$counter = 1;
					?>
					<table class="table table-head-fixed text-nowrap table-striped">
						<thead>
						<tr>
							<th style="text-align: center;">No</th>
							<th style="text-align: center;">Item Name</th>
							<th style="text-align: center;">Service Type</th>
							<th style="text-align: center;">Price</th>
							<th style="text-align: center;">Action</th>
						</tr>
						</thead>
						<tbody id="order_detail">
						<?php if (isset($orderData)): ?>
							<?php $odetail = $orderData['order_detail']; ?>
							<?php foreach ($odetail as $key => $d): ?>
								<?php
								$total = $total + $d["typeprice"];
								$estimateDay = $estimateDay + $d["estimate_day"]
								?>
								<tr>
									<td><?php echo $counter; ?></td>
									<td>
										<?php echo $d["item_name"] ?>
										<?php
										$desc = array();
										if ($d["size"] != "") {
											$desc[] = "<strong>Size</strong>: " . $d["size"];
										}
										if ($d["color_tali"] != "") {
											$desc[] = "<strong>Shoelaces</strong>: " . $d["color_tali"];
										}
										if ($d["color_insole"] != "") {
											$desc[] = "<strong>Insole</strong>: " . $d["color_insole"];
										}
										if (sizeof($desc) > 0) echo "<br/>";
										echo implode(", ", $desc);
										?>
									</td>
									<td><?php echo $d["typename"] ?></td>
									<td style="text-align: right;"><?php echo number_format($d["typeprice"], 0, ",", "."); ?></td>
									<td style="text-align: center;">
										<?php

										if ($orderData["header"]["payment_status_id"] != 2) {
											$wo = $d["work_status"];
											switch ($wo) {
												case "0":
													echo buildButton($d, array("addExtra", "readyToPickup", "editDetail", "delete"));
													break;
												case "1":
													echo buildButton($d, array("pickup", "cancelDone"));
													break;
												case "2":
													echo buildButton($d, array("pickupInfo", "revertTaken"));
													break;
											}
										}else{
											$wo = $d["work_status"];
											switch ($wo) {
												case "0":
													echo buildButton($d, array("addExtra", "readyToPickup", "editDetail", "delete"));
													break;
												case "1":
													echo buildButton($d, array("pickup", "cancelDone"));
													break;
												case "2":
													echo buildButton($d, array("pickupInfo", "revertTaken"));
													break;
											}
										}

										?>

									</td>
								</tr>
								<?php if (sizeof($d['order_extra']) > 0): ?>
									<?php $detailExtra = $d["order_extra"]; ?>
									<tr>
										<td colspan="5" class="table_extra_container">
											<div class="order_extra">
												<table class="table_order_extra table table-head-fixed text-nowrap">
													<thead>
													<tr>
														<th style="text-align: center;">No</th>
														<th style="text-align: center;">Service Name</th>
														<th style="text-align: center;">Service Price</th>
														<th style="text-align: center;">Action</th>
													</tr>
													</thead>
													<tbody>
													<?php
													$iCounter = 1;
													for ($i = 0; $i < sizeof($detailExtra); $i++) {
														$extraTotal = $extraTotal + $detailExtra[$i]->typeprice;
														$estimateDay = $estimateDay + $detailExtra[$i]->estimate_day;
														?>
														<tr>
															<td><?php echo $iCounter ?></td>
															<td><?php echo $detailExtra[$i]->typename; ?></td>
															<td style="text-align: right;"><?php echo number_format($detailExtra[$i]->typeprice, 0, ",", "."); ?></td>
															<td style="text-align: center;">
																<?php if ($orderData["header"]["payment_status_id"] != 2 && $d["work_status"] == "0"): ?>
																<a
																		href="javascript:void(0)"
																		data-serviceid="<?php echo $detailExtra[$i]->service_id ?>"
																		class="btn_delete_order_detail_extra btn btn-danger btn-sm"
																		data-id="<?php echo $detailExtra[$i]->id ?>"
																		data-detailid="<?php echo $detailExtra[$i]->detail_id ?>">Delete<a/>
																	<?php else: ?>
																		N/A
																	<?php endif; ?>
															</td>
														</tr>
														<?php
														$iCounter++;
													}
													?>
													</tbody>
												</table>
											</div>
										</td>
									</tr>
								<?php endif; ?>
								<?php $counter++; ?>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
					<br/>
					<div class="col-sm-12">
						<div class="col-md-7" style="float: left">
							&nbsp;
						</div>
						<div class="col-md-5" style="float: left">
							<?php
							$eTotal = 0;
							$hasItemDetail = false;
							$dp = 0;
							$tp = 0;
							$gt = 0;
							if (isset($orderData)) {
								$dp = $orderData["header"]["down_payment"];
								$tp = $orderData["header"]["total_payment"];
								$gt = $total + $extraTotal;
								$hasItemDetail = sizeof($odetail) > 0;
								if ($dp == "0") {
									if ($tp == $gt) {
										$eTotal = 0;
									} else {
										$eTotal = $total + $extraTotal;
									}
								} else {
									$eTotal = ($total + $extraTotal) - $orderData["header"]["down_payment"];
								}
							}

							?>

							<div class="form-group row">
								<label for="txt_total" class="col-sm-6 col-form-label">Total</label>
								<div class="col-sm-6">
									<input type="hidden" style="text-align: right;" readonly="readonly" id="txt_total"
												 name="txt_total" class="form-control form-control-sm"
												 value="<?php echo $gt; ?>">
									<input type="text" style="text-align: right;" readonly="readonly"
												 id="txt_total_display" name="txt_total_display"
												 class="form-control form-control-sm"
												 value="<?php echo formatCurrency($gt); ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="txt_current_dp" class="col-sm-6 col-form-label">Down Payment</label>
								<div class="col-sm-6">
									<input type="hidden" min="0" minlength="1"
												 value="<?php echo $dp; ?>"
												 style="text-align: right;"
												 id="txt_current_dp" name="txt_current_dp"
												 class="form-control form-control-sm">
									<input type="text" readonly min="0" minlength="1"
												 value="<?php echo formatCurrency($dp); ?>"
												 style="text-align: right;"
												 id="txt_current_dp_display" name="txt_current_dp_display"
												 class="form-control form-control-sm">
								</div>
							</div>
							<div class="form-group row">
								<label for="txt_dp" class="col-sm-6 col-form-label">Payment</label>
								<div class="col-sm-6">
									<input
											type="number" <?= ($gt == $tp && $hasItemDetail == true) ? "readonly='readonly' value='" . $tp . "'" : "value='0'" ?>
											min="0" minlength="1" style="text-align: right;"
											id="txt_dp" name="txt_dp" class="form-control form-control-sm">
								</div>
							</div>
							<div class="form-group row">
								<label for="txt_balance_display" class="col-sm-6 col-form-label">Remaining Payment
									<em>(Balance)</em></label>
								<div class="col-sm-6">

									<input type="hidden" min="0" minlength="1"
												 value="<?php echo isset($orderData) ? $eTotal : 0; ?>"
												 style="text-align: right;"
												 id="txt_balance" name="txt_balance" class="form-control form-control-sm">


									<input readonly type="text" min="0" minlength="1"
												 value="<?php echo formatCurrency(isset($orderData) ? $eTotal : 0); ?>"
												 style="text-align: right;"
												 id="txt_balance_display" name="txt_balance_display"
												 class="form-control form-control-sm">
								</div>
							</div>


						</div>
					</div>
				</div>
				<div class="card-footer">

					<!--					<button type="button" id="btn_save_draft" class="btn btn-success">Save As Draft</button>-->
					<!--					<button type="button" id="btn_submit" class="btn btn-success btn_submit">Submit Order</button>-->
					<?php
					$showSaveButton = true;
					if (isset($orderData)) {
						if (($orderData["header"]["order_status_id"] == 2) && ($orderData["header"]["pickup_date"] != "")) {
							$showSaveButton = false;
						} else if (($orderData["header"]["order_status_id"] == 2) && ($orderData["header"]["pickup_date"] == "")) {
							$showSaveButton = false;
						}
					}
					?>
					<?php
					$showPrint = false;
					if (isset($orderData)) {
						$showPrint = true;
					}
					?>

					<?php if ($showPrint): ?>
						<button type="button" class="btn btn-primary btn_print_order" data-id="<?= $orderData["header"]["id"]; ?>">
							Print Order
						</button>
					<?php endif; ?>
					<?php if ($showSaveButton): ?>
						<button type="button" class="btn btn-success btn_save_order">Save Order</button>
					<?php endif; ?>
					<button type="button" id="btn_cancel" class="btn btn-default btn_cancel">Cancel</button>
				</div>
				<!-- /.card-body -->
			</div>
		</div>

	</div>
	<div class="row">

	</div>
</form>

<script type="text/javascript">
	var orderUrl = '<?php echo $orderUrl;?>/';
</script>
