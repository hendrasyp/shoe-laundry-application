<?php
$header = $order["header"];
$detail = $order["order_detail"];
$extra_detail = array();
?>


<table style="width: 100%;" class="" id="table_order">
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
			<td style="width: 150px" class="print_border-bottom">
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
						$extra[$i] = "++ ". $detailExtra[$i]->typename;// . " (". number_format($detailExtra[$i]->typeprice, 0, ".", ",").")";
						$extraPrice[$i] ="Rp. ". number_format($detailExtra[$i]->typeprice, 0, ".", ",");
						$tmpPrice = $tmpPrice + $detailExtra[$i]->typeprice;
					}
					echo implode("<br/> ",$extra);
				}
				?>
			</td>

			<td class="print_border-bottom dt-body-right">Rp.
				<?= number_format($d["typeprice"], 0, ",", "."); ?><br/>
				<?php
				if (sizeof($extraPrice) >0){
					echo implode("<br/> ",$extraPrice);

				}
				?>
			</td>
		</tr>

		<?php $counter++; ?>
	<?php endforeach; ?>
	</tbody>
</table>
