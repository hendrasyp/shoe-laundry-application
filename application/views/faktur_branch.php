<?php
	$header = $order["header"];
	$detail = $order["order_detail"];
	$extra_detail = array();
?>

<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="width: 50%;">
			<div id="branch_info">
				<span style="font-weight: bold; font-size: 11px;">Branch:</span><br/>
				<span><?=$header["order_location"];?></span><br/>
				<span>Address: <?=$header["order_location"];?></span><br/>
				<span>Phone: <?=$header["order_location"];?></span><br/>
				<span>Website: <?=$header["order_location"];?></span><br/>
				<span>Email: <?=$header["order_location"];?></span><br/>
			</div>
		</td>
		<td valign="top" style="text-align: right;">
			<div id="customer_info" style="text-align: right;">
				<span style="font-weight: bold; font-size: 11px;">Customer Details:</span><br/>
				<span><?=ucwords(strtolower($header["cust_name"]));?></span><br/>
				<span><?=$header["phone"];?></span><br/>
				<?php if ($header["email"] != "") echo ucwords(strtolower($header["email"])); ?>
			</div>
		</td>
	</tr>
</table>
