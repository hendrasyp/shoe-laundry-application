<?php
$header = $order["header"];
$detail = $order["order_detail"];
$extra_detail = array();
do_debug($oheader);
?>

<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width: 175px;vertical-align: top;">
			<img style="width:151px;" src="<?= base_url('assets/img/floki-01.png'); ?>"/>
		</td>
		<td style="width: 150px;vertical-align: top;">
			<div id="branch_info">
				<span style="font-weight: bold; font-size: 11px;">Branch:</span><br/>
				<span style="font-weight: bold"><?= $header["order_location"]; ?></span><br/>
				<span style="font-weight: bold">Address: <?= $header["branch_address"]; ?></span><br/>
				<span style="font-weight: bold">Phone: <?= $header["branch_phone"]; ?></span><br/>
				<span style="font-weight: bold">Website: <?= $header["branch_website"]; ?></span><br/>
				<span style="font-weight: bold">Email: <?= $header["branch_email"]; ?></span><br/>
			</div>
		</td>
		<td style="width: 150px;vertical-align: top">
			<div id="customer_info" style="text-align: right;">
				<span style="font-weight: bold; font-size: 11px;">Customer Details:</span><br/>
				<span style="font-weight: bold"><?= ucwords(strtolower($header["cust_name"])); ?></span><br/>
				<span style="font-weight: bold"><?= addZeroToPhone($header["phone"]); ?></span><br/>
				<?php if ($header["email"] != "") echo '<span style="font-weight: bold">' . ucwords(strtolower($header["email"])) . "</span>"; ?>
			</div>
		</td>
		<td valign="top" style="text-align: right;">
			<table style="width: 265px;" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width: 100px;"><strong>Payment Status</strong></td>
					<td style="width: 5px;">:</td>
					<td>
						<?php
						$payment_status_text = "UNPAID";
						if ($header["total_payment"] > 0 && ($header["total_payment"] >= $header["total_after_discount"])) {
							$payment_status_text = "PAID";
						} else if ($header["total_payment"] > 0 && ($header["total_payment"] < $header["total_after_discount"])) {
							$payment_status_text = "HALF-PAID";
						} else if ($header["total_payment"] == 0 && ($header["down_payment"] > 0)) {
							$payment_status_text = "HALF-PAID";
						}
						?>
						<strong><?= $payment_status_text; ?></strong>
					</td>
				</tr>
				<tr>
					<td><strong>Invoice Number</strong></td>
					<td>:</td>
					<td><strong><?= @$oheader["order_no"]; ?></strong></td>
				</tr>
				<tr>
					<td><strong>Order Date</strong></td>
					<td>:</td>
					<td><strong><?= formatDate("d F Y", $oheader["order_date"]); ?></strong></td>
				</tr>
				<tr>
					<td><strong>Finish at</strong></td>
					<td style="2px">:</td>
					<?php if ($oheader["finish_date"] == ""): ?>
						<?php if ($oheader["finish_date_estimation"] == ""): ?>
							<td><strong>UNSET</strong></td>
						<?php else: ?>
							<td><strong><?= formatDate("d F Y", $oheader["finish_date_estimation"]); ?></strong></td>
						<?php endif; ?>
					<?php else: ?>
						<td><strong><?= formatDate("d F Y", $oheader["finish_date"]); ?></strong></td>
					<?php endif; ?>
				</tr>
				<?php if ($oheader["pickup_date"] != ""): ?>
					<tr>
						<td><strong>Pick Date</strong></td>
						<td style="2px">:</td>
						<td><strong><?= formatDate("d F Y", $oheader["pickup_date"]); ?></strong></td>
					</tr>
				<?php endif; ?>
			</table>
		</td>

	</tr>
</table>
