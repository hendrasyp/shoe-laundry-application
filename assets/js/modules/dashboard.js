function generateGrafikOrderStatus() {
	var pieChartCanvas = $('#orderMasukRekap').get(0).getContext('2d')
	var pieData        = donutData;
	var pieOptions     = {
		maintainAspectRatio : false,
		responsive : true,
	}
	//Create pie or douhnut chart
	// You can switch between pie and douhnut using the method below.
	var pieChart = new Chart(pieChartCanvas, {
		type: 'pie',
		data: pieData,
		options: pieOptions
	});

}

function generateGrafikWorkStatus() {
	var temp0 = workStatusData.datasets[0]
	var temp1 = workStatusData.datasets[1]
	var temp2 = workStatusData.datasets[2]
	workStatusData.datasets[0] = temp0
	workStatusData.datasets[1] = temp1
	workStatusData.datasets[2] = temp2

	var ChartCanvas = $('#workStatusRekap').get(0).getContext('2d');
	var ChartData = jQuery.extend(true, {}, workStatusData);

	var ptBarChart = new Chart(ChartCanvas, {
		type: 'bar',
		data: ChartData,
		options: {
			//tooltipTemplate: addCommas(value)
			tooltips: {
				callbacks: {
					label: function (tooltipItem, data) {
						return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
					}
				}
			},
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
					stacked: true,
				}],
				yAxes: [{
					stacked: true
				}]
			}
		},
	});

}

function generateGrafikPaymentStatus() {
	var temp0 = paymentStatusData.datasets[0]
	var temp1 = paymentStatusData.datasets[1]
	var temp2 = paymentStatusData.datasets[2]
	paymentStatusData.datasets[0] = temp0;
	paymentStatusData.datasets[1] = temp1;
	paymentStatusData.datasets[2] = temp2;


	var ptBarChartCanvas = $('#paymentRekap').get(0).getContext('2d');
	var ptChartData = jQuery.extend(true, {}, paymentStatusData);

	var ptBarChart = new Chart(ptBarChartCanvas, {
		type: 'bar',
		data: ptChartData,
		options: {
			//tooltipTemplate: addCommas(value)
			tooltips: {
				callbacks: {
					label: function (tooltipItem, data) {
						return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
					}
				}
			},
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
					stacked: true,
				}],
				yAxes: [{
					stacked: true
				}]
			}
		},
	});
}

$(document).ready(function () {
	generateGrafikWorkStatus();
	generateGrafikPaymentStatus();
	generateGrafikOrderStatus();
});
