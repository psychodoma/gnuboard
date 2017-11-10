<?
$week_day = get_total_visit_week_sql();
$week_str = array();

while( $row = sql_fetch_array( $week_day ) ){
    array_push($week_str,$row['vs_count']);
}

?>

<script src="<?=G5_JS_URL?>/Chart.bundle.js"></script>
<script src="<?=G5_JS_URL?>/utils.js"></script>


<div style='height:250px;'><canvas id="chart-2"></canvas></div>


	<script>
		var presets = window.chartColors;
		var utils = Samples.utils;
		var inputs = {
			min: -1000,
			max: 1000,
			count: 7,
			decimals: 2,
			continuity: 1
		};

		function generateData(config) {
            //alert( utils.numbers(Chart.helpers.merge(inputs, config || {})) );

            var y = [<?=$week_str[0]?>, <?=$week_str[1]?>, <?=$week_str[2]?> , <?=$week_str[3]?> , <?=$week_str[4]?> , <?=$week_str[5]?> , <?=$week_str[6]?>];
			return y;
		}

		function generateLabels(config) {
			return utils.months(Chart.helpers.merge({
				count: inputs.count,
				section: 10
			}, config || {}));
		}

		var options = {
			maintainAspectRatio: false,
			spanGaps: false,
			elements: {
				line: {
					tension: 0.000001
				}
			},
			plugins: {
				filler: {
					propagate: false
				}
			},
			scales: {
				xAxes: [{
					ticks: {
						autoSkip: false,
						maxRotation: 0
					}
				}]
			}
		};

		//[false, 'origin', 'start', 'end'].forEach(function(boundary, index) { 

			// reset the random seed to generate the same data for all charts
			utils.srand(8);

			new Chart('chart-2', {
				type: 'line',
				data: {
					labels: generateLabels(),
					datasets: [{
						backgroundColor: utils.transparentize(presets.green),
						borderColor: presets.green,
						data: generateData(),
						label: '접속자',
						fill: 'start'
					}]
				},
				options: Chart.helpers.merge(options, {
					title: {
						text: '월별 접속자 통계 그래프',
						display: true
					}
				})
			});
		//});


		function toggleSmooth1(btn) {
			var value = btn.classList.toggle('btn-on');
			Chart.helpers.each(Chart.instances, function(chart) {
				chart.options.elements.line.tension = value? 0.4 : 0.000001;
				chart.update();
			});
		}

		function randomize1() {
			var seed = utils.rand();
			Chart.helpers.each(Chart.instances, function(chart) {
				utils.srand(seed);

				chart.data.datasets.forEach(function(dataset) {
					dataset.data = generateData();
				});

				chart.update();
			});
		}
	</script>
