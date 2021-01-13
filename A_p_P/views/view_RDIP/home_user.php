<?php echo validation_errors(); 
require 'navbar_admin.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<style>
	body{ margin: 0; }
	/* Set the size of the div element that contains the map */
	#map {
		/*margin-left:25%;*/
		/*padding: 1px 16px;*/
		/*width:90%;*/
		height: 640px;
	}
	#data, #allData{ display: none; }
</style>
</head>
<body><br>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<select title="Year Range" class="form-control" id="year"> -->
					<?php 
					foreach ($year as $row) {
						echo "<option value='".$row->Year."'>".$row->Year."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-md-9">
				<select title="Chapters" class="form-control" id="chapters"></select>
			</div>
		</div><p></p>
		<div class="row" id="map"></div>
	</div>

	<div id="openModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" style="max-width: 95%;">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Project Overview</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<table class="table dt-responsive" border="1">
						<tr>
							<td width="20%">Title</td>
							<td width="80%" id="td_Title" colspan="7"></td>
						</tr>
						<tr>
							<td>Project Brief</td>
							<td id="td_Prog_Proj_Brief" colspan="7"></td>
						</tr>
						<tr>
							<td>Agency</td>
							<td id="td_AgencyID"></td>
						</tr>
						<tr>
							<td>Finance Source</td>
							<td id="td_FSID"></td>
						</tr>
						<tr>
							<td>Spatial Coverage</td>
							<td id="td_Spatial_Coverage"></td>
						</tr>
						<tr>
							<td>Total Investment Cost</td>
							<td id="td_Total_Inv_Cost"></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer"></div>
			</div>
			<!-- Modal content-->
		</div>
	</div>
</body>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGEO_W1u6maof5BD6vL2l5feb0WFV9JJU"></script>
<script>
	var geocoder;
	var map;
	$(document).ready(function(){

		//dynamic chapters via selected year
		$.ajax({
			url: "<?php echo base_url('controller_RDIP/controller_project/get_rdip_masterlist_chapter');?>",
			type: "POST",
			data: { Year:$('#year').val() },
			dataType: "text",
			success: function(data){
				$('#chapters').html(data);

				plot();
			}
		});

		function plot(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_home_user/get_projects');?>",
				type: "POST",
				data: { year:$('#year').val(), chapter:$('#chapters').val() },
				dataType: "JSON",
				success: function(data){
					console.log(data.projects);

					$.each(data.projects, function(key, data){
						console.log(data.Title);
					});

					//trial lang to ahhh
					//load map
					var manila = {lat: 14.6042, lng: 120.9822};
					map = new google.maps.Map(document.getElementById('map'),{
						zoom: 7,
						center: manila
					});

					//set markers
					$.each(data.projects, function(key, data){
						var marker = new google.maps.Marker({
							position: {lat: parseFloat(data.Latitude), lng: parseFloat(data.Longitude)},
							map: map,
							title: data.Title
						});

						//add listener when a marker is clicked
						google.maps.event.addListener(marker, 'click', function(event) {
							$("#openModal").modal("show");
							$('#td_Title').html(data.Title);
							$('#td_Prog_Proj_Brief').html(data.Prog_Proj_Brief);
							$('#td_AgencyID').html(data.Agency);
							$('#td_FSID').html(data.FS);
							$('#td_Spatial_Coverage').html(data.Spatial_Coverage);
							$('#td_Total_Inv_Cost').html(data.Total_Inv_Cost);
						});

					});
				}
			});
		}

		//dynamic chapters via selected year
		$('#year').on('change', function(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_project/get_rdip_masterlist_chapter');?>",
				type: "POST",
				data: { Year:$('#year').val() },
				dataType: "text",
				success: function(data){
					$('#chapters').html(data);

					plot();
				}
			});
		});

		$('#chapters').on('change', function(){
			plot();
		});

	});
</script>
</body>