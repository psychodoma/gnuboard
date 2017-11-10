<?
$week_day = get_total_visit_week_sql();
$week_str = array();
while( $row = sql_fetch_array( $week_day ) ){
    array_push($week_str,$row['vs_count']);
}

?>

<script src="<?=G5_JS_URL?>/Chart.bundle.js"></script>
<script src="<?=G5_JS_URL?>/utils.js"></script>


<div style='height:235px;'><canvas id="chart-4"></canvas></div>


	<script>
		var presets = window.chartColors;
		var utils = Samples.utils;
		var inputs = {
			min: -1000,
			max: 1000,
			count: 2,
			decimals: 2,
			continuity: 2
        };
        
		function generateData(config) {

            var y = ['<?=$line1[1]?>', '<?=$line2[1]?>'];
			return y;
		}

		function generateData2(config) {

           var y = ['<?=$line1[1]?>', '<?=$line2[1]?>'];
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

			new Chart('chart-4', {
				type: 'line',
				data: {
					labels: generateLabels(),
					datasets: [{
						backgroundColor: utils.transparentize(presets.red),
						borderColor: presets.red,
						data: generateData(),
						label: '글 수',
						fill: 'false'
					},{
						backgroundColor: utils.transparentize(presets.purple),
						borderColor: presets.purple,
						data: generateData2(),
						label: '댓글 수',
						fill: 'false'
					}]
				},
				options: Chart.helpers.merge(options, {
					title: {
						text: '<?=$line1[0]?>  ~  <?=$line2[0]?>     사이의 그래프',
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
