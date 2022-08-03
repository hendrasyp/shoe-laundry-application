<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Order No <?php echo $oheader['order_no']; ?></title>

	<style type="text/css">

		::selection {
			background-color: #E13300;
			color: white;
		}

		::-moz-selection {
			background-color: #E13300;
			color: white;
		}

		body {
			background-color: #fff;
			margin: 40px;
			font: 13px/20px normal Helvetica, Arial, sans-serif;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}

		code {
			font-family: Consolas, Monaco, Courier New, Courier, monospace;
			font-size: 12px;
			background-color: #f9f9f9;
			border: 1px solid #D0D0D0;
			color: #002166;
			display: block;
			margin: 14px 0 14px 0;
			padding: 12px 10px 12px 10px;
		}

		#body {
			margin: 0 15px 0 15px;
		}

		p.footer {
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}

		#container {
			margin: 10px;
			border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}

		#table_order, .table_order_extra {
			width: 100%;
		}

		.table_order_extra tr th,
		#table_order tr th {
			background-color: slategray;
			color: #FFFFD5;
		}

		#table_order tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		div.order_extra {

		}

		#order_container {
			margin: 10px;
			border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}

		td {
			padding-left: 5px;
			padding-right: 5px;
		}

		.dt-body-right {
			text-align: right;
		}

		.dt-body-center {
			text-align: center;
		}

		td.print_border-bottom {
			border-bottom: 1px solid black !important;
		}
	</style>
</head>
<body>

<div id="container">
	<table id="table_faktur" style="width: 100%">
		<tr>
			<td style="width: 65%;text-align: left;">
				<table style="width: 100%">
					<tr>
						<td style="width: 256px">
							<img src="https://dummyimage.com/256x110/000/fff"/>
						</td>
						<td valign="top">
							<table style="width: 100%" border="0">
								<tr>
									<td style="width: 40%"><strong>No Faktur</strong></td>
									<td>: <?= $oheader["order_no"];?></td>
								</tr>
								<tr>
									<td><strong>Order Date</strong></td>
									<td>: <?= $oheader["order_date"];?></td>
								</tr>
								<tr>
									<td><strong>Payment Status</strong></td>
									<td>: <?= $oheader["payment_status_text"];?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td style="width: 35%;text-align: left" valign="top">
				<table style="width: 100%">
					<tr>
						<td><strong>Customer Name</strong></td>
						<td>: <?= $oheader["cust_name"];?></td>
					</tr>
					<tr>
						<td><strong>Customer Email</strong></td>
						<td>: <?= $oheader["email"];?></td>
					</tr>
					<tr>
						<td><strong>Phone</strong></td>
						<td>: <?= $oheader["phone"];?></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<div id="order_container">
					<table style="width: 100%;border-bottom: 2px double gray;" class="" id="table_order">
						<thead>
						<tr>
							<th style="width: 5%;">No</th>
							<th>Item Name</th>
							<th>Service Type</th>
							<th>Price</th>
						</tr>
						</thead>
						<tbody id="order_detail">
						<?php
						$total = 0;
						$extraTotal = 0;
						$estimateDay = 0;
						$counter = 1;
						?>

						<?php foreach ($odetail as $key => $d): ?>
							<?php
							$total = $total + $d["typeprice"];
							$estimateDay = $estimateDay + $d["estimate_day"]
							?>
							<tr>
								<td class="print_border-bottom"><?= $counter; ?></td>
								<td class="print_border-bottom">
									<?= $d["item_name"] ?>
									<?= ($d["item_description"] != "") ? "<br/>(" . $d["item_description"] . ")" : ""; ?>
								</td>
								<td class="print_border-bottom"><?= $d["typename"] ?></td>
								<td class="print_border-bottom dt-body-right"><?= number_format($d["typeprice"], 0, ",", "."); ?></td>
							</tr>
							<?php $detailExtra = $d["order_extra"]; ?>
							<?php if (sizeof($detailExtra) > 0): ?>
								<tr>
									<td colspan="4" style="margin-left: 20px;padding-left: 20px;">
										<div style="" class=""><strong>Extra Service</strong></div>
										<div class="order_extra" style="margin-left: 20px;">
											<table cellpadding="3" cellspacing="3" border="0"
												   class="table table-head-fixed text-nowrap table_order_extra">
												<thead>
												<tr>
													<th style="width: 5%">No</th>
													<th>Service Name</th>
													<th>Service Price</th>
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
														<td><?= $iCounter ?></td>
														<td><?= $detailExtra[$i]->typename; ?></td>
														<td class="dt-body-right"><?= number_format($detailExtra[$i]->typeprice, 0, ".", ","); ?></td>
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

						</tbody>
					</table>
					<div style="">
						<table width="100%" border="0">
							<tr>
								<td style="width: 75%; border: 1px solid #000" rowspan="3">
									<table style="width: 100%">
										<tr>
											<td><img src="<?= $qr; ?>" width="114px"/></td>
											<td>
												Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
												Ipsum has been the industry's standard dummy text ever since the 1500s, when an
												unknown printer took a galley of type and scrambled it to make a type specimen
												book.
											</td>
										</tr>
									</table>
								</td>
								<td style="width: 10%; text-align: right;"><strong>Total</strong></td>
								<td style="width: 15%; text-align: right;"><?= number_format($oheader["total_after_discount"]); ?></td>
							</tr>
							<tr>
								<td width="25%" style="width: 25%; text-align: right;"><strong>Payment</strong></td>
								<td width="25%"
									style="width: 25%; text-align: right;"><?= number_format($oheader["payment"]); ?></td>
							</tr>
							<tr>
								<td width="25%" style="width: 25%; text-align: right;"><strong>Change</strong></td>
								<td width="25%"
									style="width: 25%; text-align: right;"><?= number_format($oheader["change"]); ?></td>
							</tr>
						</table>
					</div>

				</div>
			</td>
		</tr>
	</table>
</div>

</body>
</html>
