<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<?php 	echo validation_errors(); 
require 'navbar_admin.php'; ?>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">User Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table table-responsive">
					<tbody>
						<tr style="display: none;">
							<td><label>Username</label></td>
							<td><input type="text" id="modal_username_original" class="form-control"></td>
						</tr>
						<tr>
							<td width="40%"><label>Username</label></td>
							<td width="50%"><input type="text" id="modal_username" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Password</label></td>
							<td><input type="password" id="modal_password" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Type</label></td>
							<td>
								<select class="form-control" id="modal_type">
									<option value="3">User</option>
									<option value="2">Admin</option>
									<option value="1">Super Admin</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label>Agency</label></td>
							<td>
								<select class="form-control" id="modal_agency">
									<?php 
									foreach ($agencies as $row) {
										echo "<option value='".$row->AgencyID."'>".$row->Name."</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><label>Status</label></td>
							<td>
								<select class="form-control" id="modal_status">
									<option value="1">Allowed</option>
									<option value="0">Blocked</option>
								</select>
							</td>
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

<br><div class="table-responsive" style="padding-left:0.5%;padding-right:0.5%;">
	<div>
		<button class="btn btn-secondary" type="button" id="id_all_users">Display all records</button>
		<button class="btn btn-primary" type="button" id="id_some_users" hidden>Display batch records</button>
	</div>
	<table id="id_users" class="table table-bordered">
		<thead>
			<tr>  
				<th width="30%">Username</th>
				<th width="30%">Password</th>  
				<th width="10%">Type</th>  
				<th width="10%">Agency ID</th>  
				<th width="5%">Status</th>
				<th width="15%">Action</th>
			</tr>
		</thead>
		<tbody id="live_data">
			<?php
			$i=0;
			foreach($data as $row){
				echo "<tr>";
				echo "<td id='Username".$i."' class='Username'>".$row->Username."</td>";
				echo "<td style='-webkit-text-security:disc;' id='Password".$i."' class='Password'>".$row->Password."</td>";
				if($row->Type==1) echo "<td id='Type".$i."' class='Type'>Super Admin</td>";
				else if($row->Type==2) echo "<td id='Type".$i."' class='Type'>Admin</td>";
				else if($row->Type==3) echo "<td id='Type".$i."' class='Type'>User</td>";
				else echo "<td id='Type".$i."' class='Type'>null</td>";
				echo "<td id='Agency".$i."' class='Agency'>".$row->AgencyID."</td>";
				if($row->Status==1) echo "<td id='Status".$i."' class='Status'>Allowed</td>";
				else if($row->Status==0) echo "<td id='Status".$i."' class='Status'>Blocked</td>";
				else echo "<td id='Status".$i."' class='Status'>null</td>";
				echo "<td>
				<div id='SaveBtn".$i."' class='btn-group'>
				<button type='button' id='".$row->Username."' class='btn btn-xs btn-warning btn_save' data-toggle='modal' data-target='#myModal' onclick='pass_user_credentials(\"$row->Username\", \"$row->Password\", \"$row->Type\", \"$row->AgencyID\", \"$row->Status\")'>
				Update
				</button>
				<button type='button' id='".$row->Username."' class='btn btn-xs btn-danger btn_delete' >
				Delete
				</button>
				</div>
				</td>";
				echo "</tr>";
				$i++;
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<form>
					<td name="Username" id="id_username" ></td>
					<td name="Password" id="id_password" ></td>
					<td name="Type" id="id_type" ></td>
					<td name="Agency" id="id_agencyid" ></td>
					<td name="Status" id="id_status" ></td>
					<td>
						<button name="btn_add" id="id_reset" class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal" onclick="reset_modal_content()" type="button">+</button>
					</td>
				</form>
			</tr>
		</tfoot>
	</table>
	<div align="right">
		<button id="id_previous" class="btn btn-primary" type="button" disabled>Previous</button>
		<button id="id_next" class="btn btn-primary" type="button">Next</button><br>
		<label id="output">1</label>
	</div>
</div>
<script>
	$('#id_users').dataTable( {
		"searching": true,
		"bStateSave": true,
		"bProcessing": true,
		"paging": false,
		"bInfo": false
	} );
</script>
<script type="text/javascript">
	$(document).ready(function(){

		//
		// $('#id_users').DataTable( {
		// 	dom: 'Bfrtip',
		// 	buttons: [
		// 	{
		// 		extend: 'collection',
		// 		text: 'Export',
		// 		buttons: [{extend: 'excel', text: 'Excel'}, 'pdf']
		// 	},
		// 	'print'
		// 	]
		// } ); 
		//

		var container;
		var content;
		var ctr=1;

	//filtering buttons
	$('#id_all_users').click(function() {
		document.getElementById("id_all_users").disabled = true;
		document.getElementById("id_previous").disabled = true;
		document.getElementById("id_next").disabled = true;
		document.getElementById("id_reset").disabled = true;
		document.getElementById("id_all_users").hidden = true;
		document.getElementById("id_some_users").hidden = false;

       		//destroy the current datatable
       		$("#id_users").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_users_list/reload_table/-1');?>", 
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_users').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var u = $(this).prop('id');
						var prompt = confirm("Delete "+u+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_users_list/user_delete');?>",
								type: "POST",
								data: { Username:u },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_users").DataTable().clear().destroy();

					       				//document.getElementById("id_reset").disabled = false;
					       				document.getElementById("id_all_users").disabled = false;
					       				document.getElementById("id_previous").disabled = false;
					       				document.getElementById("id_next").disabled = false;
					       				document.getElementById("id_reset").disabled = false;
					       				document.getElementById("id_all_users").hidden = false;
					       				document.getElementById("id_some_users").hidden = true;	
					       			}
					       			alert(data.message);
					       		}
					       	});
						}
					});
					//reestablish event connection
				}  
			});
       	});

	$('#id_some_users').click(function() {
		document.getElementById("id_all_users").disabled = false;
		document.getElementById("id_previous").disabled = false;
		document.getElementById("id_next").disabled = false;
		document.getElementById("id_reset").disabled = false;
		document.getElementById("id_all_users").hidden = false;
		document.getElementById("id_some_users").hidden = true;

		ctr=1;
		document.getElementById("output").innerHTML = ctr;
		if(ctr==1){
			document.getElementById("id_previous").disabled = true;
		}

       		//destroy the current datatable
       		$("#id_users").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_users_list/reload_table/0');?>", 
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_users').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var u = $(this).prop('id');
						var prompt = confirm("Delete "+u+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_users_list/user_delete');?>",
								type: "POST",
								data: { Username:u },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_users").DataTable().clear().destroy();

					       				document.getElementById("id_reset").disabled = false;
					       			}
					       			alert(data.message);
					       		}
					       	});
						}
					});
					//reestablish event connection
				}  
			});
       	});
	//filtering buttons

	//custom pagination
	$('#id_next').click(function() {
		$('#output').html(function(i, val) {
			ctr += 1;
			document.getElementById("output").innerHTML = ctr;
			document.getElementById("id_previous").disabled = false;

       		//destroy the current datatable
       		$("#id_users").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_users_list/reload_table/');?>"+ctr, 
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_users').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var u = $(this).prop('id');
						var prompt = confirm("Delete "+u+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_users_list/user_delete');?>",
								type: "POST",
								data: { Username:u },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_users").DataTable().clear().destroy();

					       				document.getElementById("id_reset").disabled = false;
					       			}
					       			alert(data.message);
					       		}
					       	});
						}
					});
					//reestablish event connection
				}  
			});
       	});
	});

	$('#id_previous').click(function() {
		$('#output').html(function(i, val) {
			ctr -= 1;
			document.getElementById("output").innerHTML = ctr;
			if(ctr==1){
				document.getElementById("id_previous").disabled = true;
			}

       		//destroy the current datatable
       		$("#id_users").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_users_list/reload_table/');?>"+ctr, 
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_users').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var u = $(this).prop('id');
						var prompt = confirm("Delete "+u+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_users_list/user_delete');?>",
								type: "POST",
								data: { Username:u },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_users").DataTable().clear().destroy();

					       				document.getElementById("id_reset").disabled = false;	
					       			}
					       			alert(data.message);
					       		}
					       	});
						}
					});
					//reestablish event connection
				}  
			});
       	});
	});
	//custom pagination

	function fetch_data(){
		$.ajax({
			url:"<?php echo base_url('controller_RDIP/controller_users_list/reload_table/0');?>", 
			type:"POST",  
			data:{VarIndicator:1},
			dataType:"text",
			success:function(data){
				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_users').dataTable({
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					});

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var u = $(this).prop('id');
						var prompt = confirm("Delete "+u+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_users_list/user_delete');?>",
								type: "POST",
								data: { Username:u },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_users").DataTable().clear().destroy();

					       				document.getElementById("id_reset").disabled = false;
					       			}
					       			alert(data.message);
					       		}
					       	});
						}
					});
					//reestablish event connection

					ctr=1;
					document.getElementById("output").innerHTML = ctr;
					if(ctr==1){
						document.getElementById("id_previous").disabled = true;
					}
				}  
			});
	}

	$('#id_btn_add').on('click', function(){
		var u = $('#modal_username').val();
		var p = $('#modal_password').val();
		var t = $('#modal_type').val();
		var a = $('#modal_agency').val();
		var s = $('#modal_status').val();

		if(u == ''){  
			alert("Enter Username");  
			return false;  
		}
		if(p == ''){  
			alert("Enter Password");  
			return false;  
		}
		if(t == ''){  
			alert("Enter User Type");  
			return false;  
		}
		if(a == ''){  
			alert("Enter Agency");  
			return false;  
		}
		if(s == ''){  
			alert("Enter Status");  
			return false;  
		}

		$.ajax({
			url: "<?php echo base_url('controller_RDIP/controller_users_list/user_add');?>",
			type: "POST",
			data: { Username:u, Password:p, Type:t, Agency:a, Status: s },
			dataType: "JSON",
			success: function(data){
				if(data.success == true)
				{
					fetch_data();
					$("#id_users").DataTable().clear().destroy();
					$('#myModal').modal('hide');
				}

				alert(data.message);

       				// $('#id_username').text('');
       				// $('#id_password').text('');
       				// $('#id_type').text('');
       				// $('#id_agencyid').text('');
       				// $('#id_status').text('');

       				//destroy the current datatable
       			}
       		});
	});

	$('#id_btn_edit').on('click', function(){
		var Old_Username = $('#modal_username_original').val();
		var Username = $('#modal_username').val();
		var Password = $('#modal_password').val();
		var Type = $('#modal_type').val();
		var Agency = $('#modal_agency').val();
		var Status = $('#modal_status').val();

			//console.log(Old_Username + " " + Username + " " + Password + " " + Type + " " + Agency + " " + Status);

			if(Username == ''){  
				alert("Enter Username");  
				return false;  
			}
			if(Password == ''){  
				alert("Enter Password");  
				return false;  
			}
			if(Type == ''){  
				alert("Enter Type");  
				return false;  
			}
			if(Agency == ''){  
				alert("Enter Agency");  
				return false;  
			}
			if(Status == ''){  
				alert("Enter Status");  
				return false;  
			}

			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_users_list/user_edit');?>",
				type: "POST",
				data: { Old_Username:Old_Username, Username:Username, Password:Password, Type:Type, Agency:Agency, Status: Status },
				dataType: "JSON",
				success: function(data){
	   				//alert("Editing success!!!");
	   				if(data.success == true){
	   					fetch_data();

		   				//destroy the current datatable
		   				$("#id_users").DataTable().clear().destroy();

		   				$('#myModal').modal('hide');

		   				document.getElementById("id_all_users").disabled = false;
		   				document.getElementById("id_previous").disabled = false;
		   				document.getElementById("id_next").disabled = false;
		   				document.getElementById("id_reset").disabled = false;
		   				document.getElementById("id_all_users").hidden = false;
		   				document.getElementById("id_some_users").hidden = true;
		   			}
		   			alert(data.message);
		   		}
		   	});
		});

	$('.btn_delete').on('click', function(){
		var u = $(this).prop('id');
		var prompt = confirm("Delete "+u+" ?");

		if(prompt==true){
			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_users_list/user_delete');?>",
				type: "POST",
				data: { Username:u },
				dataType: "JSON",
				success: function(data){
					//alert("What a successful deletion!!!");
					if(data.success==true){
						fetch_data();

	       				//destroy the current datatable
	       				$("#id_users").DataTable().clear().destroy();

	       				document.getElementById("id_reset").disabled = false;	
	       			}
	       			alert(data.message);
	       		}
	       	});
		}
	});
});

function pass_user_credentials(Username,Password,Type,Agency,Status){
	$('#modal_username_original').val(Username);
	$('#modal_username').val(Username);
	$('#modal_password').val(Password);
	$('#modal_type').val(Type);
	$('#modal_agency').val(Agency);
	$('#modal_status').val(Status);

	document.getElementById("id_btn_add").hidden = true;
	document.getElementById("id_btn_edit").hidden = false;

		//console.log(Username + " " + Password + " " + Type + " " + Agency + " " + Status);
	}

	function reset_modal_content(){
		$('#modal_username_original').val("");
		$('#modal_username').val("");
		$('#modal_password').val("");
		$('#modal_type').val(3);
		$('#modal_agency').val(1);
		$('#modal_status').val(1);

		document.getElementById("id_btn_add").hidden = false;
		document.getElementById("id_btn_edit").hidden = true;
	}
</script>