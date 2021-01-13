<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<?php 	echo validation_errors(); 
require 'navbar_admin.php'; ?>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Fund Source Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table table-responsive">
					<tbody>
						<tr style="display: none;">
							<td><label>Fund Source ID</label></td>
							<td><input type="text" id="modal_fsid_original" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Fund Source Name</label></td>
							<td><input type="text" id="modal_name" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Description</label></td>
							<td><input type="text" id="modal_description" class="form-control"></td>
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
		<button class="btn btn-secondary" type="button" id="id_all_fund_source">Display all records</button>
		<button class="btn btn-primary" type="button" id="id_some_fund_source" hidden>Display batch records</button>
	</div>
	<table id="id_fund_source" class="table table-bordered">
		<thead>
			<tr>  
				<th width="5%">FSID</th>
				<th width="30%">Fund Name</th>  
				<th width="50%">Description</th>  
				<th width="15%">Action</th>
			</tr>
		</thead>
		<tbody id="live_data">

		</tbody>
		<tfoot>
			<tr>
				<form>
					<td name="FSID" id="id_fsid" ></td>
					<td name="Name" id="id_name" ></td>
					<td name="Description" id="id_description" ></td>
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
<script type="text/javascript">
	$(document).ready(function(){
		var ctr=1;

	//filtering buttons
	$('#id_all_fund_source').click(function() {
		document.getElementById("id_all_fund_source").disabled = true;
		document.getElementById("id_previous").disabled = true;
		document.getElementById("id_next").disabled = true;
		document.getElementById("id_reset").disabled = true;
		document.getElementById("id_all_fund_source").hidden = true;
		document.getElementById("id_some_fund_source").hidden = false;

       		//destroy the current datatable
       		$("#id_fund_source").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_fund_source/reload_table/-1');?>",
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_fund_source').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var FSID = $(this).prop('id');
						var prompt = confirm("Delete "+FSID+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_fund_source/delete_fund_source');?>",
								type: "POST",
								data: { FSID:FSID },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_fund_source").DataTable().clear().destroy();

					       				//document.getElementById("id_reset").disabled = false;
					       				document.getElementById("id_all_fund_source").disabled = false;
					       				document.getElementById("id_previous").disabled = false;
					       				document.getElementById("id_next").disabled = false;
					       				document.getElementById("id_reset").disabled = false;
					       				document.getElementById("id_all_fund_source").hidden = false;
					       				document.getElementById("id_some_fund_source").hidden = true;
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

	$('#id_some_fund_source').click(function() {
		document.getElementById("id_all_fund_source").disabled = false;
		document.getElementById("id_previous").disabled = false;
		document.getElementById("id_next").disabled = false;
		document.getElementById("id_reset").disabled = false;
		document.getElementById("id_all_fund_source").hidden = false;
		document.getElementById("id_some_fund_source").hidden = true;

		ctr=1;
		document.getElementById("output").innerHTML = ctr;
		if(ctr==1){
			document.getElementById("id_previous").disabled = true;
		}

       		//destroy the current datatable
       		$("#id_fund_source").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_fund_source/reload_table/0');?>",
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_fund_source').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var FSID = $(this).prop('id');
						var prompt = confirm("Delete "+FSID+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_fund_source/delete_fund_source');?>",
								type: "POST",
								data: { FSID:FSID },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_fund_source").DataTable().clear().destroy();

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
       		$("#id_fund_source").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_fund_source/reload_table/');?>"+ctr, 
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_fund_source').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var FSID = $(this).prop('id');
						var prompt = confirm("Delete "+FSID+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_fund_source/delete_fund_source');?>",
								type: "POST",
								data: { FSID:FSID },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_fund_source").DataTable().clear().destroy();

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
       		$("#id_fund_source").DataTable().clear().destroy();

       		$.ajax({
       			url:"<?php echo base_url('controller_RDIP/controller_fund_source/reload_table/');?>"+ctr, 
       			type:"POST",  
       			data:{VarIndicator:1},
       			dataType:"text",
       			success:function(data){
       				$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_fund_source').dataTable( {
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					} );

					//reestablish event connection
					$('.btn_delete').on('click', function(){
						var FSID = $(this).prop('id');
						var prompt = confirm("Delete "+FSID+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_fund_source/delete_fund_source');?>",
								type: "POST",
								data: { FSID:FSID },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
									if(data.success==true){
										fetch_data();

					       				//destroy the current datatable
					       				$("#id_fund_source").DataTable().clear().destroy();

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
    		url:"<?php echo base_url('controller_RDIP/controller_fund_source/reload_table/0');?>", 
    		type:"POST",  
    		data:{VarIndicator:1},
    		dataType:"text",
    		success:function(data){
    			$('#live_data').html(data);  

					//reinstantiate the datatable
					$('#id_fund_source').dataTable({
						"searching": true,
						"bStateSave": true,
						"bProcessing": true,
						"paging": false,
						"bInfo": false
					});

					//establish event connection
					$('.btn_delete').on('click', function(){
						var FSID = $(this).prop('id');
						var prompt = confirm("Delete "+FSID+" ?");

						if(prompt==true){
							$.ajax({
								url: "<?php echo base_url('controller_RDIP/controller_fund_source/delete_fund_source');?>",
								type: "POST",
								data: { FSID:FSID },
								dataType: "JSON",
								success: function(data){
									//alert("What a successful deletion!!!");
				       				//console.log(FSID);
				       				if(data.success==true){
				       					fetch_data();

					       				//destroy the current datatable
					       				$("#id_fund_source").DataTable().clear().destroy();

					       				document.getElementById("id_reset").disabled = false;	
					       			}
					       			alert(data.message);
					       		}
					       	});
						}
					});
					//establish event connection

					ctr=1;
					document.getElementById("output").innerHTML = ctr;
					if(ctr==1){
						document.getElementById("id_previous").disabled = true;
					}
				}  
			});
    }
    fetch_data();

    $('#id_btn_add').on('click', function(){
    	var Name = $('#modal_name').val();
    	var Description = $('#modal_description').val();

    	if(Name == ''){  
    		alert("Enter Fund Source Name");  
    		return false;  
    	}
    	if(Description == ''){  
    		alert("Enter Description");  
    		return false;  
    	}

    	$.ajax({
    		url: "<?php echo base_url('controller_RDIP/controller_fund_source/add_fund_source');?>",
    		type: "POST",
    		data: { Name:Name, Description: Description },
    		dataType: "JSON",
    		success: function(data){
    			//alert("What a successful insertion!!!");
    			if(data.success==true){
    				fetch_data();

       				//destroy the current datatable
       				$("#id_fund_source").DataTable().clear().destroy();

       				$('#myModal').modal('hide');
       			}
       			alert(data.message);
       		}
       	});
    });

    $('#id_btn_edit').on('click', function(){
    	var FSID = $('#modal_fsid_original').val();
    	var Name = $('#modal_name').val();
    	var Description = $('#modal_description').val();

    	if(Name == ''){  
    		alert("Enter Fund Source Name");  
    		return false;  
    	}
    	if(Description == ''){  
    		alert("Enter Description");  
    		return false;  
    	}

    	$.ajax({
    		url: "<?php echo base_url('controller_RDIP/controller_fund_source/update_fund_source');?>",
    		type: "POST",
    		data: { FSID:FSID, Name:Name, Description: Description },
    		dataType: "JSON",
    		success: function(data){
    			//alert("Editing success!!!");
    			if(data.success==true){
    				fetch_data();

	   				//destroy the current datatable
	   				$("#id_fund_source").DataTable().clear().destroy();

	   				$('#myModal').modal('hide');

	   				document.getElementById("id_all_fund_source").disabled = false;
	   				document.getElementById("id_previous").disabled = false;
	   				document.getElementById("id_next").disabled = false;
	   				document.getElementById("id_reset").disabled = false;
	   				document.getElementById("id_all_fund_source").hidden = false;
	   				document.getElementById("id_some_fund_source").hidden = true;
	   			}
	   			alert(data.message);
	   		}
	   	});
    });

});

function pass_fund_source_credentials(ID,Name,Description){
	$('#modal_fsid_original').val(ID);
	$('#modal_name').val(Name);
	$('#modal_description').val(Description);

	document.getElementById("id_btn_add").hidden = true;
	document.getElementById("id_btn_edit").hidden = false;

		//console.log(Username + " " + Password + " " + Type + " " + Agency + " " + Status);
	}

	function reset_modal_content(){
		$('#modal_fsid_original').val("");
		$('#modal_name').val("");
		$('#modal_description').val("");

		document.getElementById("id_btn_add").hidden = false;
		document.getElementById("id_btn_edit").hidden = true;
	}
</script>