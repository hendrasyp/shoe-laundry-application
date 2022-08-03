<?php
$header = $order["header"];
$detail = $order["order_detail"];
$extra_detail = array();
?>


	<?php
	$total = 0;
	$extraTotal = 0;
	$estimateDay = 0;
	$counter = 1;
	?>
<table>
	<tr>
		<td style="font-style: italic;font-weight: bold;">Terima kasih atas partisipasi Anda dalam kegiatan Clean & Share. Dana yang terkumpul akan didonasikan kepada Saudara kita yang membutuhkan.</td>
	</tr>
</table>
<table style="border: 0px dashed #000b16;width: 100%">
	<tr>
		<td style="width:500px;border: 0px solid #000" valign="top" >
			<span style="font-weight: bold; font-size: 11px;font-style: italic;">Term & Condition:</span><br/>
			<ol>
				<li style="font-weight: bold;">Nota harap dibawa pada saat pengambilan.</li>
				<li style="font-weight: bold;">Apabila tidak dapat menunjukan nota, harap menunjukan kartu identitas asli.</li>
				<li style="font-weight: bold;">Jika sepatu tidak diambil dalam waktu 30 hari dari tanggal selesai, seluruh kondisi sepatu (kotor, rusak, dll) diluar tanggung jawab kami.</li>
				<li style="font-weight: bold;">Sepatu yang sudah diambil, bukan merupakan tanggung jawab kami.</li>
				<li style="font-weight: bold;">Pengajuan keluhan dapat dilakukan paling lambat 24 jam setelah pengambilan.</li>
				<li style="font-weight: bold;">Apabila terjadi kerusakan pada sepatu yang diakibatkan pencucian, kami akan mengganti maksimal sebesar 3 (tiga) kali dari biaya service.</li>
				<li style="font-weight: bold;">Apabila terjadi hal-hal lain seperti bencana alam, kebakaran dan peperangan yang mengakibatkan kerusakan atau kondisi lain, diluar tanggung jawab kami.</li>
				<li style="font-weight: bold;">Setelah menandatangani nota, konsumen dianggap menyetujui pernyataan ini.</li>
			</ol>
			<br/>
			<table style="width: 100%">
				<tr>
					<td width="50%"><span style="text-align: center;font-weight: bold;font-size: 10px">Customer</span></td>
					<td width="50%"><span style="text-align: center;font-weight: bold;font-size: 10px">FLOKI</span></td>
				</tr>
				<tr>
					<td width="100%" colspan="2">&nbsp; <br/> &nbsp; <br/> &nbsp; <br/></td>
				</tr>
				<tr>
					<td width="50%"><span style="text-align: center;font-weight: bold;font-size: 10px">(<?=$header["cust_name"];?>)</span></td>
					<td width="50%"><span style="text-align: center;font-weight: bold;font-size: 10px">(<?=$header["employee_name"];?>)</span></td>
				</tr>
			</table>
		</td>
		<td style="text-align: right;" valign="top">
			<table style="border: 0px">
				<tr>
					<td><strong>Total</strong></td>
					<td><strong>:</strong></td>
					<td style="text-align: right;">Rp. <?= number_format($header["total_after_discount"]); ?></td>
				</tr>
				<tr>
					<td><strong>Down Payment</strong></td>
					<td><strong>:</strong></td>
					<td style="text-align: right;">Rp. <?= number_format($header["down_payment"]); ?></td>
				</tr>
				<tr>
					<td><strong>Total Payment</strong></td>
					<td><strong>:</strong></td>
					<td style="text-align: right;">Rp. <?= number_format($header["total_payment"]); ?></td>
				</tr>
				<tr>
					<td><strong>Balance <br/><em>(Remaining Payment)</em></strong></td>
					<td><strong>:</strong></td>
					<td style="text-align: right;">Rp.
						<?php
							$balance = $header["total_after_discount"] -
									(($header["total_payment"] == 0) ? $header["down_payment"]:$header["total_payment"]);
						?>
						<?= number_format($balance); ?>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: center;"><img src="<?= $qr; ?>" width="114px"/></td>
				</tr>

			</table>

		</td>

	</tr>

</table>
