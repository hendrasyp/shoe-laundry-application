<?php
	$header = $order["header"];
	$detail = $order["order_detail"];
	$extra_detail = array();
?>

<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="width: 50%; text-align: left">
			<div id="branch_info">
				<span style="font-weight: bold; font-size: 11px;">Order Details:</span><br/>
			</div>
		</td>
		<td valign="top" style="text-align: right;">
			<div id="customer_info" style="text-align: right;">
				<span style="font-weight: bold; font-size: 11px;">Item Qty: <?=sizeof($detail)?></span><br/>
			</div>
		</td>
	</tr>
</table>
