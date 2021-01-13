<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<style type="text/css">
table.dataTable thead { background-color: #ababab; }
table.dataTable tr.odd { background-color: #E2E4FF; }
table.dataTable tr.even { background-color: white; }
</style>

<?php 	echo validation_errors(); 
require 'navbar_admin.php'; ?>

<!-- Modal -->
<div id="myModal_project_selection" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Project Selection Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table table-responsive">
					<tbody>
						<tr>
							<td><label>Year Range</label></td>
							<td>
								<select class="form-control" id="modal_year">
									<?php 
									foreach ($year as $row) {
										echo "<option value='".$row->Year."'>".$row->Year."</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><label>Chapter Number</label></td>	
							<td>
								<select class="form-control" id="live_chapter">

								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" id="id_btn_proceed" class="btn btn-success" data-toggle="modal" data-target="#myModal_project_creation">Proceed</button>
			</div>
		</div>
		<!-- Modal content-->
	</div>
</div>
<!-- Modal -->

<!-- Modal -->
<div id="myModal_project_creation" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:95%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Project Creation Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table table-responsive">
					<tbody>
						<tr style="display: none;">
							<td><label>ID</label></td>
							<td><input type="text" id="modal_ID" class="form-control"></td>
						</tr>
						<tr>
							<td>Title</td>
							<td colspan="4"><input type="text" id="modal_Title" class="form-control"></td>
							<td>Priority</td>
							<td>
								<input type="checkbox" id="modal_Prio_No" value="0" style="zoom: 1.75;">
							</td>
						</tr>
						<tr>
							<td rowspan="3">Program Project Brief</td>
							<td colspan="4" rowspan="3">
								<textarea rows="6" style="resize:none;" id="modal_Prog_Proj_Brief" class="form-control"></textarea>
							</td>
							<td>Agency</td>
							<td>
								<select class="form-control" id="modal_Agency">
									<?php 
									foreach ($agencies as $row) {
										echo "<option value='".$row->AgencyID."'>".$row->Name."</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Finance Source</td>
							<td>
								<select class="form-control" id="modal_FSID">
									<?php 
									foreach ($fund as $row) {
										echo "<option value='".$row->FSID."'>".$row->Name."</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Spatial Coverage</td>
							<td>
								<select class="form-control" id="modal_Spatial_Coverage">
									<option value="1">Batanes</option>
									<option value="2">Cagayan</option>
									<option value="3">Isabela</option>
									<option value="4">Nueva Vizcaya</option>
									<option value="5">Quirino</option>
									<option value="6">Regionwide</option>
								</select>
							</td>
						</tr>
						<tr>
							<td id="modal_th_y1">Year 1</td>
							<td id="modal_th_y2">Year 2</td>
							<td id="modal_th_y3">Year 3</td>
							<td id="modal_th_y4">Year 4</td>
							<td id="modal_th_y5">Year 5</td>
							<td id="modal_th_y6">Year 6</td>
							<td>Total Investment Cost</td>
						</tr>
						<tr>
							<td><input type="number" id="modal_Year_1" class="form-control YR"></td>
							<td><input type="number" id="modal_Year_2" class="form-control YR"></td>
							<td><input type="number" id="modal_Year_3" class="form-control YR"></td>
							<td><input type="number" id="modal_Year_4" class="form-control YR"></td>
							<td><input type="number" id="modal_Year_5" class="form-control YR"></td>
							<td><input type="number" id="modal_Year_6" class="form-control YR"></td>
							<td><input type="number" id="modal_Total_Inv_Cost" class="form-control"></td>
						</tr>
						<tr>
							<td>Latitude</td>
							<td><input type="text" id="modal_Latitue" class="form-control"></td>
							<td>Longitude</td>
							<td><input type="text" id="modal_Longitude" class="form-control"></td>
							<td><a type="button" id="id_map" class="btn btn-success" data-toggle="modal" data-target="#check_map">Plot</a></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" id="id_btn_add" class="btn btn-success" >Add</button>
				<button type="button" id="id_btn_edit" class="btn btn-success" >Save</button>
			</div>
		</div>
		<!-- Modal content-->
	</div>
</div>
<!-- Modal -->

<style type="text/css">
.container {
	height: px;
}
#map {
	width: 100%;
	height: 400px;
	border: 1px solid blue;
}
#data, #allData {
	display: none;
}
</style>
<!-- Modal -->
<div id="check_map" tabindex="-1" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Project Plotting Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div id="map"></div>
				<p id="hoverPosition"></p>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" id="id_btn_add" class="btn btn-success" >Add</button> -->
				<button type="button" id="id_save" class="btn btn-success" >Save</button>
			</div>
		</div>
		<!-- Modal content-->
	</div>
</div>
<!-- Modal -->

<!-- Modal -->
<div id="myModal_status_management" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:70%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Status Management Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table table-hover"  width="100%" style="font-size:15px;">
					<thead>
						<tr>
							<th id="th_proj_id"></th>
							<th colspan="4" id="th_proj_title"></th>
						</tr>
						<tr>
							<th width="5%" title="Code">Code</th>
							<th width="18%" title="Status">Status</th>
							<th width="55%" title="Remarks">Remarks</th>
							<th width="17%" title="Date">Date</th>
							<?php 
							if(($_SESSION['user_type']==1) || ($_SESSION['user_type']==2)){
								echo '<th width="5%" title="Action">Action</th>';
							}
							?>
						</tr>
					</thead>
					<tbody id="live_status">
						
					</tbody>
					<tfoot>
						<?php 
						if(($_SESSION['user_type']==1) || ($_SESSION['user_type']==2)){
							echo '<tr>
							<td><input type="text" id="tf_modal_Status_Code" style="display:none;"></td>
							<td>
							<select class="form-control" id="tf_modal_Status">
							<option value="O">Ongoing</option>
							<option value="C">Completed</option>
							<option value="A">Archived</option>
							<option value="X">Others</option>
							</select>
							</td>
							<td>
							<textarea rows="3" style="resize:none;" id="tf_modal_Remarks" class="form-control"></textarea>
							</td>
							<td></td>
							<td>
							<button type="button" id="id_btn_Status_edit" class="btn btn-warning" style="display:none;">Save</button>
							<button type="button" id="id_btn_Status_add" class="btn btn-success" >+</button>
							</td>
							</tr>';
						}
						?>
					</tfoot>
				</table>
			</div>
			<div class="modal-footer"></div>
		</div>
		<!-- Modal content-->
	</div>
</div>
<!-- Modal -->

<br><div>
	<table class="table table-hover"  width="80%" style="font-size:15px;">
		<tr>
			<td style="width:20%;">
				<select title="Year Range" class="form-control" id="year">
					<?php 
					foreach ($year as $row) {
						echo "<option value='".$row->Year."'>".$row->Year."</option>";
					}
					?>
				</select>
			</td>
			<td style="width:65%;">
				<select title="Chapters" class="form-control" id="chapters">
				</select>
			</td>
			<td style="width:15%;">
				<?php 
				if(($_SESSION['user_type']==1) || ($_SESSION['user_type']==2)){
					echo '<button name="" id="id_reset" class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal_project_selection" onclick="reset_modal_content()" type="button">Add Record</button>';
				}
				?>
			</td>
		</tr>
	</table>
</div>
<br><div class="table-responsive" id="">
	<div id="">
		<!-- <table class="table table-hover nowrap" id="live_data" width="100%"> -->
			<table class="table table-hover" id="live_data" width="100%" style="font-size:15px;">
				<thead>
					<tr>
						<!-- <th width="3%" title="ID">ID</th> -->
						<th width="10%" title="Title">Title</th>
						<th width="29%" title="Program Project Brief">Program Project Brief</th>
						<th width="3%" title="Agency ID">Agency</th>
						<th width="5%" title="Spatial Coverage">Coverage</th>
						<th width="3%" title="Financial Source ID">Source</th>
						<th width="5%" title="Year 1" id="th_y1">Y1</th>
						<th width="5%" title="Year 2" id="th_y2">Y2</th>
						<th width="5%" title="Year 3" id="th_y3">Y3</th>
						<th width="5%" title="Year 4" id="th_y4">Y4</th>
						<th width="5%" title="Year 5" id="th_y5">Y5</th>
						<th width="5%" title="Year 6" id="th_y6">Y6</th>
						<th width="7%" title="Total Investment Cost">Total</th>
						<th width="5%" title="Status">Status</th>
					<!-- <th width="6%" title="Latitude">Lat</th>
						<th width="6%" title="Longitude">Long</th> -->
						<!-- <th width="3%" title="Priority Number">PNo</th> -->
						<?php 
						if(($_SESSION['user_type']==1) || ($_SESSION['user_type']==2)){ echo '<th width="5%">Action</th>'; 
					}
					?>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		var live_table;
		var marker;
		var lat;
		var lng;

		//dynamic chapters via selected year
		$.ajax({
			url: "<?php echo base_url('controller_RDIP/controller_project/get_rdip_masterlist_chapter');?>",
			type: "POST",
			data: { Year:$('#year').val() },
			dataType: "text",
			success: function(data){
				let ctr_year = $('#year').val();
				ctr_year = Number(ctr_year.substring(0,4));
				$('#th_y1').html(ctr_year);
				$('#th_y2').html(ctr_year+1);
				$('#th_y3').html(ctr_year+2);
				$('#th_y4').html(ctr_year+3);
				$('#th_y5').html(ctr_year+4);
				$('#th_y6').html(ctr_year+5);

				$('#chapters').html(data);

				short_delay();
			}
		});

		//dynamic modal chapters via selected year
		var Year = $('#modal_year').val();
		$.ajax({
			url: "<?php echo base_url('controller_RDIP/controller_project/get_rdip_masterlist_chapter');?>",
			type: "POST",
			data: { Year:Year },
			dataType: "text",
			success: function(data){
				$('#live_chapter').html(data);
			}
		});

   		//instantiation of datatable
   		function short_delay(){
   			live_table = $('#live_data').DataTable({
   				"processing": true,
   				"serverSide": true,
   				"ajax": {
   					"url": "<?php echo base_url('controller_RDIP/controller_project/getData/');?>",
   					"type": "post",
   					"data": function(data){
   						console.log("year="+$('#year').val()+"&"+"chapters="+$('#chapters').val());
   						return "year="+$('#year').val()+"&"+"chapters="+$('#chapters').val()+"&"+$.param(data);
   					}
   				},
   				"columns": [
            	// {
	            // 	"class-name": "align-middle",
	            // 	"render": function(data, type, row){
	            // 		return row["ID"];
            	// 	}
            	// },
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Title"];
            		}
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Prog_Proj_Brief"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["agency_Name"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			if(row["Spatial_Coverage"]==1) return "Batanes";
            			else if(row["Spatial_Coverage"]==2) return "Cagayan";
            			else if(row["Spatial_Coverage"]==3) return "Isabela";
            			else if(row["Spatial_Coverage"]==4) return "Nueva Vizcaya";
            			else if(row["Spatial_Coverage"]==5) return "Quirino";
            			else if(row["Spatial_Coverage"]==6) return "Regionwide";
            			else return "null";
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["funding_src_Name"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Year_1"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Year_2"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Year_3"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Year_4"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Year_5"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Year_6"];
            		},
            		"orderable": false
            	},
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return row["Total_Inv_Cost"];
            		}
            	},
            	// {
	            // 	"class-name": "align-middle",
	            // 	"render": function(data, type, row){
	            // 		return row["Latitude"];
            	// 	},
            	// 	"orderable": false
            	// },
            	// {
	            // 	"class-name": "align-middle",
	            // 	"render": function(data, type, row){
	            // 		return row["Longitude"];
            	// 	},
            	// 	"orderable": false
            	// },
            	// {
	            // 	"class-name": "align-middle",
	            // 	"render": function(data, type, row){
	            // 		return row["Prio_No"];
            	// 	}
            	// },
            	{
            		"class-name": "align-middle",
            		"render": function(data, type, row){
            			return "<button type='button' id='' data-toggle='modal' data-target='#myModal_status_management' onclick='manage_project_status(\""+row['ID']+"\",\""+row['Title']+"\")'>Manage</button>";
            		},
            		"orderable": false
            	} 
            	<?php 
            	if(($_SESSION['user_type']==1) || ($_SESSION['user_type']==2)){
            		echo ',
            		{
            			"class-name": "align-middle",
            			"render": function(data, type, row){

            				return "<button type=\'button\' id=\'\' data-toggle=\'modal\' data-target=\'#myModal_project_creation\' onclick=\'pass_project_credentials(\""+row[\'ID\']+"\",\""+row[\'Title\']+"\",\""+row[\'Prog_Proj_Brief\']+"\",\""+row[\'AgencyID\']+"\",\""+row[\'Spatial_Coverage\']+"\",\""+row[\'FSID\']+"\",\""+row[\'Year_1\']+"\",\""+row[\'Year_2\']+"\",\""+row[\'Year_3\']+"\",\""+row[\'Year_4\']+"\",\""+row[\'Year_5\']+"\",\""+row[\'Year_6\']+"\",\""+row[\'Total_Inv_Cost\']+"\",\""+row[\'Latitude\']+"\",\""+row[\'Longitude\']+"\",\""+row[\'Prio_No\']+"\")\'>Update</button>";


            			},
            			"orderable": false
            		}';
            	}
            	?>
            	]
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
					let ctr_year = $('#year').val();
					ctr_year = Number(ctr_year.substring(0,4));
					$('#th_y1').html(ctr_year);
					$('#th_y2').html(ctr_year+1);
					$('#th_y3').html(ctr_year+2);
					$('#th_y4').html(ctr_year+3);
					$('#th_y5').html(ctr_year+4);
					$('#th_y6').html(ctr_year+5);

					$('#chapters').html(data);

					live_table.ajax.reload();
				}
			});
		});

		$('#chapters').on('change', function(){
			live_table.ajax.reload();
		});

		//dynamic modal chapters via selected year
		$('#modal_year').on('change', function(){
			var Year = $('#modal_year').val();

			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_project/get_rdip_masterlist_chapter');?>",
				type: "POST",
				data: { Year:Year },
				dataType: "text",
				success: function(data){
					$('#live_chapter').html(data);
				}
			});
		});

        //automatic summation of modal_Total_Inv_Cost
        $('.YR').on('keyup', function(){
        	let Y1 = Number($('#modal_Year_1').val());
        	let Y2 = Number($('#modal_Year_2').val());
        	let Y3 = Number($('#modal_Year_3').val());
        	let Y4 = Number($('#modal_Year_4').val());
        	let Y5 = Number($('#modal_Year_5').val());
        	let Y6 = Number($('#modal_Year_6').val());
        	var sum = Y1 + Y2 + Y3 + Y4 + Y5 + Y6;
        	$('#modal_Total_Inv_Cost').val(sum);
        });

        $('#id_btn_proceed').on('click', function(){
        	let ctr_year = $('#modal_year').val();
        	ctr_year = Number(ctr_year.substring(0,4));
        	$('#modal_th_y1').html(ctr_year);
        	$('#modal_th_y2').html(ctr_year+1);
        	$('#modal_th_y3').html(ctr_year+2);
        	$('#modal_th_y4').html(ctr_year+3);
        	$('#modal_th_y5').html(ctr_year+4);
        	$('#modal_th_y6').html(ctr_year+5);

        	$('#myModal_project_selection').modal('hide');
        });

        $('#id_map').click(function(){   
        	$('#myModal_project_creation').modal('hide');
        });

        $('#check_map').on('shown.bs.modal', function loadMap(){
        	//var manila = {lat: 14.6042, lng: 120.9822};
        	var manila = {lat: Number($('#modal_Latitue').val()), lng: Number($('#modal_Longitude').val())};
        	var map = new google.maps.Map(document.getElementById('map'),{
        		zoom: 10,
        		center: manila
        	});

        	//set a marker on the center point
        	var marker = new google.maps.Marker({
        		position: {lat: Number($('#modal_Latitue').val()), lng: Number($('#modal_Longitude').val())},
        		map: map,
        		title: 'Hello World!'
        	});

        	// //delete mo toh //working naman pala eh
        	// var marker = new google.maps.Marker({
        	// 	position: {lat: 17.5910, lng: 121.7513},
        	// 	map: map,
        	// 	title: 'Hello zzz!'
        	// });

        	map.addListener("click", function(event){

        		var pnt = event.latLng;
        		displayCoordinates(pnt);
        		lat = pnt.lat();
        		lat = lat.toFixed(4);
        		lng = pnt.lng();
        		lng = lng.toFixed(4);
        		if (marker != null){
        			marker.setMap(null);
        		}
        		marker = new google.maps.Marker(
        		{
        			position: {
        				lat: parseFloat(lat), 
        				lng: parseFloat(lng)
        			}, 
        			map: map
        		}
        		); 
        	});  
        	$("#hoverPosition").html("Latitude: " + Number($('#modal_Latitue').val()) + " , Longitude: " + Number($('#modal_Longitude').val())); 
        });

        $('#id_save').on('click', function(){
        	$('#check_map').modal('hide');
        	$('#myModal_project_creation').modal('show');
        	$('#modal_Latitue').val(lat);
        	$('#modal_Longitude').val(lng);
        });

  		// $('#myModal_project_creation').on('shown.bs.modal', function(){
  		// 	$('#modal_Latitue').val(lat);
  		// 	$('#modal_Longitude').val(lng);
  		// });

       	//adding of project record
       	$('#id_btn_add').on('click', function(){
       		var Title = $('#modal_Title').val();
       		var Prog_Proj_Brief = $('#modal_Prog_Proj_Brief').val();
       		var AgencyID = $('#modal_Agency').val();
       		var Spatial_Coverage = $('#modal_Spatial_Coverage').val();
       		var FSID = $('#modal_FSID').val();
       		var Year_1 = $('#modal_Year_1').val();
       		var Year_2 = $('#modal_Year_2').val();
       		var Year_3 = $('#modal_Year_3').val();
       		var Year_4 = $('#modal_Year_4').val();
       		var Year_5 = $('#modal_Year_5').val();
       		var Year_6 = $('#modal_Year_6').val();
       		var Total_Inv_Cost = $('#modal_Total_Inv_Cost').val();
       		var Latitude = $('#modal_Latitue').val();
       		var Longitude = $('#modal_Longitude').val();

       		if($('#modal_Prio_No').prop('checked')) var Prio_No = "1";
       		else var Prio_No = "0";

       		var rdip_ml_ID = $('#live_chapter').val();

       		if(Title == ''){  
       			alert("Enter Title");  
       			return false;  
       		}
       		if(Prog_Proj_Brief == ''){  
       			alert("Enter Program Project Brief");  
       			return false;  
       		}
       		if(AgencyID == ''){  
       			alert("Enter Agency");  
       			return false;  
       		}
       		if(Spatial_Coverage == ''){  
       			alert("Enter Spatial Coverage");  
       			return false;  
       		}
       		if(FSID == ''){  
       			alert("Enter Fund Source");  
       			return false;  
       		}
       		if(Year_1 == ''){  
       			alert("Enter Year_1");  
       			return false;  
       		}
       		if(Year_2 == ''){  
       			alert("Enter Year 2");  
       			return false;  
       		}
       		if(Year_3 == ''){  
       			alert("Enter Year 3");  
       			return false;  
       		}
       		if(Year_4 == ''){  
       			alert("Enter Year 4");  
       			return false;  
       		}
       		if(Year_5 == ''){  
       			alert("Enter Year 5");  
       			return false;  
       		}
       		if(Year_6 == ''){  
       			alert("Enter Year 6");  
       			return false;  
       		}
       		if(Total_Inv_Cost == ''){  
       			alert("Enter Total Investment Cost");  
       			return false;  
       		}
       		if(Latitude == ''){  
       			alert("Enter Latitude");  
       			return false;  
       		}
       		if(Longitude == ''){  
       			alert("Enter Longitude");  
       			return false;  
       		}

       		$.ajax({
       			url: "<?php echo base_url('controller_RDIP/controller_project/add_project');?>",
       			type: "POST",
       			data: { Title:Title, Prog_Proj_Brief:Prog_Proj_Brief, AgencyID:AgencyID, Spatial_Coverage:Spatial_Coverage, FSID:FSID, Year_1:Year_1, Year_2:Year_2, Year_3:Year_3, Year_4:Year_4, Year_5:Year_5, Year_6:Year_6, Total_Inv_Cost:Total_Inv_Cost, Latitude:Latitude, Longitude:Longitude, Prio_No:Prio_No, rdip_ml_ID:rdip_ml_ID },
       			dataType: "JSON",
       			success: function(data){
       				//alert("What a successful insertion!!!");
       				if(data.success==true){
       					live_table.ajax.reload();

       					$('#myModal_project_creation').modal('hide');
       				}
       				alert(data.message);
       			}
       		});
       	});

		//editing of project record
		$('#id_btn_edit').on('click', function(){
			var ID = $('#modal_ID').val();
			var Title = $('#modal_Title').val();
			var Prog_Proj_Brief = $('#modal_Prog_Proj_Brief').val();
			var AgencyID = $('#modal_Agency').val();
			var Spatial_Coverage = $('#modal_Spatial_Coverage').val();
			var FSID = $('#modal_FSID').val();
			var Year_1 = $('#modal_Year_1').val();
			var Year_2 = $('#modal_Year_2').val();
			var Year_3 = $('#modal_Year_3').val();
			var Year_4 = $('#modal_Year_4').val();
			var Year_5 = $('#modal_Year_5').val();
			var Year_6 = $('#modal_Year_6').val();
			var Total_Inv_Cost = $('#modal_Total_Inv_Cost').val();
			var Latitude = $('#modal_Latitue').val();
			var Longitude = $('#modal_Longitude').val();

			if($('#modal_Prio_No').prop('checked')) var Prio_No = "1";
			else var Prio_No = "0";

			if(Title == ''){  
				alert("Enter Title");  
				return false;  
			}
			if(Prog_Proj_Brief == ''){  
				alert("Enter Program Project Brief");  
				return false;  
			}
			if(AgencyID == ''){  
				alert("Enter Agency");  
				return false;  
			}
			if(Spatial_Coverage == ''){  
				alert("Enter Spatial Coverage");  
				return false;  
			}
			if(FSID == ''){  
				alert("Enter Fund Source");  
				return false;  
			}
			if(Year_1 == ''){  
				alert("Enter Year_1");  
				return false;  
			}
			if(Year_2 == ''){  
				alert("Enter Year 2");  
				return false;  
			}
			if(Year_3 == ''){  
				alert("Enter Year 3");  
				return false;  
			}
			if(Year_4 == ''){  
				alert("Enter Year 4");  
				return false;  
			}
			if(Year_5 == ''){  
				alert("Enter Year 5");  
				return false;  
			}
			if(Year_6 == ''){  
				alert("Enter Year 6");  
				return false;  
			}
			if(Total_Inv_Cost == ''){  
				alert("Enter Total Investment Cost");  
				return false;  
			}
			if(Latitude == ''){  
				alert("Enter Latitude");  
				return false;  
			}
			if(Longitude == ''){  
				alert("Enter Longitude");  
				return false;  
			}

			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_project/update_project');?>",
				type: "POST",
				data: { ID:ID, Title:Title, Prog_Proj_Brief:Prog_Proj_Brief, AgencyID:AgencyID, Spatial_Coverage:Spatial_Coverage, FSID:FSID, Year_1:Year_1, Year_2:Year_2, Year_3:Year_3, Year_4:Year_4, Year_5:Year_5, Year_6:Year_6, Total_Inv_Cost:Total_Inv_Cost, Latitude:Latitude, Longitude:Longitude, Prio_No:Prio_No },
				dataType: "JSON",
				success: function(data){
					//alert("Editing success!!!");
					if(data.success==true){
						live_table.ajax.reload();

						$('#myModal_project_creation').modal('hide');
					}
					alert(data.message);
				}
			});
		});

		$('#id_btn_Status_add').on('click',function(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_project/add_prog_proj_status');?>",
				type: "POST",
				data: { Status:$('#tf_modal_Status').val(), Remarks:$('#tf_modal_Remarks').val(), prog_proj_ID:$('#th_proj_id').html() },
				dataType: "JSON",
				success: function(data){
					if(data.success == true){
						$.ajax({
							url: "<?php echo base_url('controller_RDIP/controller_project/get_prog_proj_status');?>/"+$('#th_proj_id').html(),
							type: "POST",
							data: {  },
							dataType: "text",
							success: function(zzz){
								$('#live_status').html(zzz);
								$('#tf_modal_Status').val("O");
								$('#tf_modal_Remarks').val("Enter Remarks here...");
							}
						});
					}
					alert(data.message);
				}
			});
		});

		$('#id_btn_Status_edit').on('click',function(){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_project/update_prog_proj_status');?>",
				type: "POST",
				data: { Code:$('#tf_modal_Status_Code').val(), Status:$('#tf_modal_Status').val(), Remarks:$('#tf_modal_Remarks').val() },
				dataType: "JSON",
				success: function(data){
					if(data.success == true){
						$.ajax({
							url: "<?php echo base_url('controller_RDIP/controller_project/get_prog_proj_status');?>/"+$('#th_proj_id').html(),
							type: "POST",
							data: {  },
							dataType: "text",
							success: function(zzz){
								$('#live_status').html(zzz);
								$('#tf_modal_Status').val("O");
								$('#tf_modal_Remarks').val("Enter Remarks here...");

								$("#id_btn_Status_add").css("display","block");
								$("#id_btn_Status_edit").css("display","none");
							}
						});
					}
					alert(data.message);
				}
			});
		});

	});

function pass_project_credentials(ID,Title, Prog_Proj_Brief, AgencyID, Spatial_Coverage, FSID, Year_1, Year_2, Year_3, Year_4, Year_5, Year_6, Total_Inv_Cost, Latitude, Longitude, Prio_No){
	$('#modal_ID').val(ID);
	$('#modal_Title').val(Title);
	$('#modal_Prog_Proj_Brief').val(Prog_Proj_Brief);
	$('#modal_Agency').val(AgencyID);
	$('#modal_Spatial_Coverage').val(Spatial_Coverage);
	$('#modal_FSID').val(FSID);
	$('#modal_Year_1').val(Year_1);
	$('#modal_Year_2').val(Year_2);
	$('#modal_Year_3').val(Year_3);
	$('#modal_Year_4').val(Year_4);
	$('#modal_Year_5').val(Year_5);
	$('#modal_Year_6').val(Year_6);
	$('#modal_Total_Inv_Cost').val(Total_Inv_Cost);
	$('#modal_Latitue').val(Latitude);
	$('#modal_Longitude').val(Longitude);

	if(Prio_No=="1") $("#modal_Prio_No").prop("checked", true);
	else $("#modal_Prio_No").prop("checked", false);
	$('#modal_Prio_No').val(Prio_No);

	$('#modal_th_y1').html($('#th_y1').html());
	$('#modal_th_y2').html($('#th_y2').html());
	$('#modal_th_y3').html($('#th_y3').html());
	$('#modal_th_y4').html($('#th_y4').html());
	$('#modal_th_y5').html($('#th_y5').html());
	$('#modal_th_y6').html($('#th_y6').html());

	document.getElementById("id_btn_add").hidden = true;
	document.getElementById("id_btn_edit").hidden = false;
}

function reset_modal_content(){
	$('#modal_ID').val("");
	$('#modal_Title').val("");
	$("#modal_Prio_No").prop("checked", false);
	$('#modal_Prio_No').val("0");
	$('#modal_Spatial_Coverage').val(2);
	$('#modal_Total_Inv_Cost').val("");
	$('#modal_Year_1').val("");
	$('#modal_Year_2').val("");
	$('#modal_Year_3').val("");
	$('#modal_Year_4').val("");
	$('#modal_Year_5').val("");
	$('#modal_Year_6').val("");
	$('#modal_Prog_Proj_Brief').val("");
	$('#modal_Latitue').val("14.6042");
	$('#modal_Longitude').val("120.9822");

	document.getElementById("id_btn_add").hidden = false;
	document.getElementById("id_btn_edit").hidden = true;
}

function manage_project_status(ID, Title){
	$('#tf_modal_Status').val("O");
	$('#tf_modal_Remarks').val("Enter Remarks here...");
	$('#th_proj_id').html(ID)
	$('#th_proj_title').html(Title);

	$("#id_btn_Status_add").css("display","block");
	$("#id_btn_Status_edit").css("display","none");

	$.ajax({
		url: "<?php echo base_url('controller_RDIP/controller_project/get_prog_proj_status');?>/"+$('#th_proj_id').html(),
		type: "POST",
		data: {  },
		dataType: "text",
		success: function(zzz){
			$('#live_status').html(zzz);
		}
	});
}

function pass_status_credentials(Code, Status, Remarks){
	$('#tf_modal_Status_Code').val(Code);
	$('#tf_modal_Status').val(Status);
	$('#tf_modal_Remarks').val(Remarks);

	$("#id_btn_Status_add").css("display","none");
	$("#id_btn_Status_edit").css("display","block");
}

function loadMap(){
	var manila = {lat: 14.6042, lng: 120.9822};
	var map = new google.maps.Map(document.getElementById('map'),{
		zoom: 7,
		center: manila
	});

}
function displayCoordinates(pnt) {
	lat = pnt.lat();
	lat = lat.toFixed(4);
	lng = pnt.lng();
	lng = lng.toFixed(4);
	$("#hoverPosition").html("Latitude: " + lat + " , Longitude: " + lng);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGEO_W1u6maof5BD6vL2l5feb0WFV9JJU"></script>