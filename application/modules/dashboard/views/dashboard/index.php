<!-- Small boxes (Stat box) -->
<div class="row">
	<div class="col-md-6">
		<!-- STACKED BAR CHART -->
		<div class="card card-success">
			<div class="card-header">
				<h3 class="card-title">Rekapitulasi Berdasarkan Status Pembayaran</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
				</div>
			</div>
			<div class="card-body">
				<div class="chart">
					<canvas id="paymentRekap"
									style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
				</div>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->

	</div>
	<div class="col-md-6">
		<!-- STACKED BAR CHART -->
		<div class="card card-success">
			<div class="card-header">
				<h3 class="card-title">Rekapitulasi Order Masuk</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
				</div>
			</div>
			<div class="card-body">
				<div class="chart">
					<canvas id="orderMasukRekap"
									style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
				</div>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->

	</div>
</div>

<div class="row" style="display: none;">
	<div class="col-md-12">
		<!-- STACKED BAR CHART -->
		<div class="card card-success">
			<div class="card-header">
				<h3 class="card-title">Rekapitulasi Berdasarkan Status Pekerjaan</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
				</div>
			</div>
			<div class="card-body">
				<div class="chart">
					<canvas id="workStatusRekap"
									style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
				</div>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->

	</div>
</div>

<div class="row">

</div>

<script type="text/javascript">
	var monthLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];


	var paymentStatusData = {
		labels: monthLabel,
		datasets: [
			{
				label: 'LUNAS',
				backgroundColor: 'rgba(66, 255, 0, 0.5)',
				borderColor: 'rgba(66, 255, 0, 0.5)',
				pointRadius: false,
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: [<?=$pt_paid;?>]
			},
			{
				label: 'BELUM BAYAR',
				backgroundColor: 'rgba(255, 99, 71, 1)',
				borderColor: 'rgba(255, 99, 71, 1)',
				pointRadius: false,
				pointColor: 'rgba(210, 214, 222, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: [<?=$pt_unpaid;?>]
			}, {
				label: 'UANG MUKA',
				backgroundColor: 'rgba(248, 163, 0, 0.5)',
				borderColor: 'rgba(248, 163, 0, 0.5)',
				pointRadius: false,
				pointColor: 'rgba(210, 214, 222, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: [<?=$pt_half;?>]
			},
		]
	}

	var workStatusData = {
		labels: monthLabel,
		datasets: [
			{
				label: 'Selesai',
				backgroundColor: 'rgba(66, 255, 0, 0.5)',
				borderColor: 'rgba(66, 255, 0, 0.5)',
				pointRadius: false,
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: [<?=$closed;?>]
			},
			{
				label: 'Dalam Proses',
				backgroundColor: 'rgba(255, 99, 71, 1)',
				borderColor: 'rgba(255, 99, 71, 1)',
				pointRadius: false,
				pointColor: 'rgba(210, 214, 222, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: [<?=$in_progress;?>]
			}, {
				label: 'Siap Diambil',
				backgroundColor: 'rgba(248, 163, 0, 0.5)',
				borderColor: 'rgba(248, 163, 0, 0.5)',
				pointRadius: false,
				pointColor: 'rgba(210, 214, 222, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: [<?=$ready_to_pick;?>]
			},
		]
	}

	var donutData        = {
		labels: [<?=$jenis_layanan;?>],
		datasets: [
			{
				data: [<?=$jenis_layanan_jumlah?>],
				backgroundColor : ['#f56954', '#00a65a', '#f39c12'] //, '#00c0ef', '#3c8dbc', '#d2d6de'],
			}
		]
	}


</script>
