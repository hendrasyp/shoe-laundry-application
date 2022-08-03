<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Order No <?php echo $oheader['order_no']; ?></title>

	<style type="text/css">
		@media (print) {
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
				/*margin: 40px;*/
				font-size: 8px;
				font-family: Helvetica, Arial, sans-serif !important;
				color: #4F5155;
			}

			table tbody tr td,
			table thead tr th {
				font-size: 9px;
				font-family: Helvetica, Arial, sans-serif !important;
				color: #4F5155;
				vertical-align: top;
			}


			#body {
				margin: 0 15px 0 15px;
			}


			#container {
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

			div.order_detail {
				border: 1px solid gray;
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
				border-bottom: 1px dotted #787878 !important;
			}

		}
	</style>
</head>
<body>

<div id="container">
	<?php for ($i = 0; $i < 2; $i++): ?>
		<table border="0" style="">
			<tr>
				<td style="vertical-align: top;height: 500px;<?=($i==1)? "padding-top: 60px;":""; ?>">

					<table id="table_faktur"  style="height:567px;min-height: 567px !important;width: 100%;" border="0">
						<!-- TABLE HEADER -->
						<tr>
							<td>
								<?php $this->load->view('faktur_header', array("order" => $order)); ?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
						<tr>
							<td>
								<?php $this->load->view('faktur_predetail', array("order" => $order)); ?>
							</td>
						</tr>
						<tr>
							<td style="border: 1px dotted #5c5c5c;">
								<?php $this->load->view('faktur_detail', array("order" => $order)); ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php $this->load->view('faktur_total', array("order" => $order, "qr" => $qr)); ?>
							</td>
						</tr>


					</table>
				</td>
			</tr>
		</table>
	<?php endfor; ?>
</div>

</body>
</html>
