<?php
$header = $order["header"];
$detail = $order["order_detail"];
$detail_extra = array();

?>
<div class="row">
	<?php if ($order["isEmpty"] == false): ?>
	<div class="col-md-12">
		<div class="card card-outline card-warning">
			<div class="card-body">

					<!-- Main content -->
					<div class="invoice p-3 mb-3">
						<!-- title row -->
						<div class="row">
							<div class="col-12">
								<h4>
									Floki Order Information.

								</h4>
							</div>
							<!-- /.col -->
						</div>
						<!-- info row -->
						<div class="row invoice-info">
							<div class="col-sm-4 invoice-col">
								Branch Detail
								<address>
									<strong><?= $header["order_location"]; ?>.</strong><br>
									<?= $header["branch_address"]; ?><br>
									Phone: <?= $header["branch_phone"]; ?><br>
									Email: <?= $header["branch_email"]; ?><br>
									Website: <?= $header["branch_website"]; ?>
								</address>
							</div>
							<!-- /.col -->
							<div class="col-sm-4 invoice-col">
								Your Information
								<address>
									<strong>Mr/Mrs. <?= ucwords(strtolower($header["cust_name"])); ?></strong><br>
									Phone: <?= addZeroToPhone($header["phone"]); ?>
									<?php if ($header["email"] != ""): ?>
										<br> Email: <?= $header["email"]; ?>
									<?php endif; ?>
								</address>
							</div>
							<!-- /.col -->
							<div class="col-sm-4 invoice-col">
								<b>Invoice #<?= $header["order_no"]; ?></b><br>
								<b>Order ID:</b> <?= str_pad($header["id"], 5, "0", STR_PAD_LEFT); ?><br>
								<b>Work
									Status:</b> <?= $header["order_status_name"] == "DRAFT" ? "IN PROGRESS" : ($header["pickup_date"] != "" ? "CLOSED" : ($header["finish_date"] == "" ? $header["order_status_name"] : "READY TO PICKUP")); ?>
								<br>
								<?php
								$payment_status_text = "UNPAID";
								$dp = 0;
								if ($header["total_payment"] > 0 && ($header["total_payment"] >= $header["total_after_discount"])) {
									$payment_status_text = "PAID";
								} else if ($header["total_payment"] > 0 && ($header["total_payment"] < $header["total_after_discount"])) {
									$payment_status_text = "HALF-PAID";
									$dp = $header["total_payment"];
								} else if ($header["total_payment"] == 0 && ($header["down_payment"] > 0)) {
									$payment_status_text = "HALF-PAID";
								}
								?>
								<b>Payment Status:</b> <?= $payment_status_text; ?> <br/>
								<?php
								$finishAt = "";
								if ($header["finish_date"] == "") {
									if ($header["finish_date_estimation"] == "") {
										$finishAt = "Whether finish or estimation date are not set.";
									} else {
										$finishAt = formatDate("d F Y", $header["finish_date_estimation"]);
									}
								} else {
									$finishAt = formatDate("d F Y", $header["finish_date"]);
								}
								?>
								<?php if ($header["pickup_date"] == ""): ?>
									<!--	BUG MASIH 1970 -->
									<b>Will be finish at:</b> <?= $finishAt ?>
								<?php endif; ?>
								<?php if ($header["pickup_date"] != ""): ?>
									<b>Already Pickup at:</b> <?= formatDate("d F Y", $header["pickup_date"]) ?>
								<?php endif; ?>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->

						<!-- Table row -->
						<div class="row">
							<div class="col-12 table-responsive">
								<table style="width: 100%;" border="0" class="table table-striped" id="table_order">
									<thead>
									<tr>
										<th style="text-align: center; width: 5%">No</th>
										<th style="text-align: center; width: 55%"
										">Item Name</th>
										<th style="text-align: center;  width: 20%">Service Type</th>
										<th style="text-align: center;  width: 10%"
										">Price</th>
										<th style="text-align: center;  width: 10%"
										">Status</th>
									</tr>
									</thead>
									<?php
									$total = 0;
									$extraTotal = 0;
									$estimateDay = 0;
									$counter = 1;
									?>
									<tbody id="order_detail">
									<?php foreach ($detail as $key => $d): ?>
										<?php
										$total = $total + $d["typeprice"];
										$estimateDay = $estimateDay + $d["estimate_day"]
										?>
										<tr>
											<td style="width: 10px" class="print_border-bottom"><?= $counter; ?></td>
											<td style="width: 400px;" class="print_border-bottom">
												<?= $d["item_name"] ?>
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
												if (sizeof($desc) > 0) echo ", ";
												echo implode(", ", $desc);
												$detailExtra = $d["order_extra"]; ?>


											</td>
											<td class="print_border-bottom">
												<?= $d["typename"] ?>
												<?php $detailExtra = $d["order_extra"]; ?>
												<?php
												$tmpPrice = $d["typeprice"];
												$extraPrice = array();
												if (sizeof($detailExtra) > 0) {
													echo "<br/> ";
													$extra = array();
													for ($i = 0; $i < sizeof($detailExtra); $i++) {
														$extraTotal = $extraTotal + $detailExtra[$i]->typeprice;
														$estimateDay = $estimateDay + $detailExtra[$i]->estimate_day;
														$extra[$i] = "++ " . $detailExtra[$i]->typename;// . " (". number_format($detailExtra[$i]->typeprice, 0, ".", ",").")";
														$extraPrice[$i] = number_format($detailExtra[$i]->typeprice, 0, ".", ",");
														$tmpPrice = $tmpPrice + $detailExtra[$i]->typeprice;
													}
													echo implode("<br/> ", $extra);
												}
												?>
											</td>

											<td style="text-align: right;" class="print_border-bottom dt-body-right">
												<?= "Rp. " . number_format($d["typeprice"], 0, ",", "."); ?><br/>
												<?php
												if (sizeof($extraPrice) > 0) {
													echo implode("<br/> ", $extraPrice);
												}
												?>
											</td>
											<td style="text-align: center">
												<?= ($d["finish_date"] != "") ? (($header["pickup_date"] != "") ? "Already pickup at " . formatDate("d F Y", $d["pickup_date"]) : "Ready to Pickup") : "In Progress"; ?>
											</td>
										</tr>

										<?php $counter++; ?>
									<?php endforeach; ?>
									</tbody>
								</table>

							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->

						<div class="row">

							<table style="width: 100%;">
								<tr>
									<td style="font-style: italic;font-weight: bold;">

										Terima kasih atas partisipasi Anda dalam kegiatan Clean & Share. Dana yang terkumpul akan
										didonasikan
										kepada Saudara kita yang membutuhkan.
									</td>
								</tr>
							</table>
							<table border="0" style="padding: 20px; margin: 10px; border: 0px dashed #000b16;width: 100%">
								<tr>
									<td style="width:75%;border: 0px solid #000" valign="top">
										<span style="font-weight: bold; font-size: 11px;font-style: italic;">Term & Condition:</span><br/>
										<ol>
											<li style="font-weight: bold;">Nota harap dibawa pada saat pengambilan.</li>
											<li style="font-weight: bold;">Apabila tidak dapat menunjukan nota, harap menunjukan kartu
												identitas
												asli.
											</li>
											<li style="font-weight: bold;">Jika sepatu tidak diambil dalam waktu 30 hari dari tanggal selesai,
												seluruh kondisi sepatu (kotor, rusak, dll) diluar tanggung jawab kami.
											</li>
											<li style="font-weight: bold;">Sepatu yang sudah diambil, bukan merupakan tanggung jawab kami.
											</li>
											<li style="font-weight: bold;">Pengajuan keluhan dapat dilakukan paling lambat 24 jam setelah
												pengambilan.
											</li>
											<li style="font-weight: bold;">Apabila terjadi kerusakan pada sepatu yang diakibatkan pencucian,
												kami akan mengganti maksimal sebesar 3 (tiga) kali dari biaya service.
											</li>
											<li style="font-weight: bold;">Apabila terjadi hal-hal lain seperti bencana alam, kebakaran dan
												peperangan yang mengakibatkan kerusakan atau kondisi lain, diluar tanggung jawab kami.
											</li>
											<li style="font-weight: bold;">Setelah menandatangani nota, konsumen dianggap menyetujui
												pernyataan
												ini.
											</li>
										</ol>
									</td>
									<td style="width:25%;text-align: right;" valign="top">
										<?php
										$eTotal = 0;
										$hasItemDetail = false;
										$dp = 0;
										$tp = 0;
										$gt = 0;
										$dp = $header["down_payment"];
										$tp = $header["total_payment"];
										$gt = $total + $extraTotal;

										if ($dp == "0") {
											if ($tp == $gt) {
												$eTotal = 0;
											} else {
												$eTotal = $total + $extraTotal;
											}
										} else {
											$eTotal = ($total + $extraTotal) - $header["down_payment"];
										}

										?>
										<table style="border: 0px; width: 100%" border="0">
											<tr>
												<td><strong>Total</strong></td>
												<td><strong>:</strong></td>
												<td style="text-align: right;">Rp. <?= formatCurrency($gt); ?></td>
											</tr>
											<tr>
												<td><strong>Down Payment</strong></td>
												<td><strong>:</strong></td>
												<td style="text-align: right;">Rp. <?= formatCurrency($dp); ?></td>
											</tr>
											<tr>
												<td><strong>Total Payment</strong></td>
												<td><strong>:</strong></td>
												<td style="text-align: right;">Rp. <?= formatCurrency($tp); ?></td>
											</tr>
											<tr>
												<td><strong>Balance</strong></td>
												<td><strong>:</strong></td>
												<td style="text-align: right;">Rp.
													<?php echo formatCurrency($eTotal); ?>
												</td>
											</tr>

										</table>

									</td>

								</tr>

							</table>

						</div>
						<!-- /.row -->

						<!-- this row will not appear when printing -->
					</div>
					<!-- /.invoice -->


			</div>
			<!-- /.card-body -->
		</div>
	</div>
</div>
<?php endif; ?>
<div class="row">

</div>
<script type="text/javascript">

</script>
