<?php echo validation_errors(); ?>

<style type="text/css">
#map {
	/*margin-left:25%;*/
	/*padding: 1px 16px;*/
	/*width:90%;*/
	height: 640px;
}
</style>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Login Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table table-responsive">
					<tbody>
						<tr>
							<td width="40%"><label>Username</label></td>
							<td width="60%"><input type="text" id="modal_username" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Password</label></td>
							<td><input type="password" id="modal_password" class="form-control"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_login" class="btn btn-success" >Login</button>
			</div>
		</div>
		<!-- Modal content-->
	</div>
</div>
<!-- Modal -->

<!-- Modal -->
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
<!-- Modal -->

<!-- Navbar -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
	<a class="navbar-brand" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_index/display_contents_index">RDIP</a>
	<ul class="navbar-nav ml-auto">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
	</ul>
	<div class="collapse navbar-collapse" id="collapsibleNavbar">
<!-- 		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="#" style="color:white;">Sample 1</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="" style="color:white;" id="navbardrop" data-toggle="dropdown">
					Dropdown
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Link 1</a>
					<a class="dropdown-item" href="#">Link 2</a>
					<a class="dropdown-item" href="#">Link 3</a>
				</div>
			</li>
		</ul> -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<button class="nav-link btn" type="button" style="color:white;" data-toggle="modal" data-target="#myModal">Login</button>
			</li>
		</ul>
	</div>
</nav>
<!-- Navbar -->

<!-- Content -->
<br><div class="container">
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
<!-- Content -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGEO_W1u6maof5BD6vL2l5feb0WFV9JJU"></script>
<!-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU"></script> -->
<script>
	var geocoder;
	var map;
	$(document).ready(function(){

		$('#btn_login').on('click', function(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_index/check_user');?>",
				type: "POST",
				data: { Username:$('#modal_username').val(), Password:$('#modal_password').val() },
				dataType: "JSON",
				success: function(data){
					if(data.success==true){
						window.location.href="<?php echo base_url('controller_RDIP/controller_home_admin/display_contents_home_admin');?>";
					}
					alert(data.message);
				}
			});
		});

		//dynamic chapters via selected year
		$.ajax({
			url: "<?php echo base_url('controller_RDIP/controller_index/get_rdip_masterlist_chapter');?>",
			type: "POST",
			data: { Year:$('#year').val() },
			dataType: "text",
			success: function(data){
				$('#chapters').html(data);
				//alert(data);
				plot();
			}
		});

		function plot(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_index/get_projects');?>",
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
				url: "<?php echo base_url('controller_RDIP/controller_index/get_rdip_masterlist_chapter');?>",
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