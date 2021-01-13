<?php 	echo validation_errors(); 
require 'navbar_admin.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

<br><div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-head">
					<select title="Year Range" class="form-control pull-right" id="year" style="width:30%;">
						<?php 
						foreach ($year as $row) {
							echo "<option value='".$row->Year."'>".$row->Year."</option>";
						}
						?>
					</select>
				</div>
				<div class="card-body">
					<canvas id="myChart" style="height: 650px;"></canvas>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-head">
							<select title="Chapters" class="form-control pull-right" id="chapters" style="width:100%;"></select>
						</div>
						<div class="card-body">
							<canvas id="myChart2" style="height: 325px;"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<canvas id="myChart3"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var myPieChart;
		function load_chart2(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_home_admin/generate_chart2');?>",
				type: "POST",
				data: { year:$('#year').val(), chapter:$('#chapters').val() },
				dataType: "JSON",
				success: function(data){
					//
					var ctx2 = $('#myChart2');
					var myPieChart2 = new Chart(ctx2, {
						type: 'pie',
						data: {
							labels: data.agency,
							datasets: [{
								//label: "Population (millions)",
								//kahit marami kang stocks. Hindi naman required na kasing bilang niya yung mga ilalagay sa chart
								backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
								data: data.projects
							}]
						},
						options: {
							title: {
								display: true,
								text: 'Agency Contributions to the selected RDIP Chapter'
							},
							responsive: true,
							maintainAspectRatio: false
						}
					});
					//
				}
			});
		}
		function load_chart1(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_home_admin/generate_chart1');?>",
				type: "POST",
				data: { year:$('#year').val() },
				dataType: "JSON",
				success: function(data){
					var ctx = $('#myChart');
					myPieChart = new Chart(ctx, {
						type: 'pie',
						data: {
							labels: data.agency,
							datasets: [{
								//label: "Population (millions)",
								//kahit marami kang stocks. Hindi naman required na kasing bilang niya yung mga ilalagay sa chart
								backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#388E3C","#c45850","#D98880","#AF7AC5","#5499C7","#76D7C4","#F7DC6F","#566573","#F39C12","#536DFE","#FF1744","#FF80AB","#6A1B9A","#7986CB","#00838F","#A7FFEB"],
								data: data.projects
							}]
						},
						options: {
							title: {
								display: true,
								text: 'Agency Contributions to the selected RDIP Year'
							},
							responsive: true,
							maintainAspectRatio: false
						}
					});

					$.ajax({
						url: "<?php echo base_url('controller_RDIP/controller_project/get_rdip_masterlist_chapter');?>",
						type: "POST",
						data: { Year:$('#year').val() },
						dataType: "text",
						success: function(data){
							$('#chapters').html(data);

							load_chart2();
						}
					});
				}
			});
		}
		load_chart1();

		$('#year').on('change',function(){
			load_chart1();
		});

		$('#chapters').on('change',function(){
			load_chart2();
		});

	});
</script>