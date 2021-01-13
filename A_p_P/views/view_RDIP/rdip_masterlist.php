<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<?php 	echo validation_errors(); 
require 'navbar_admin.php'; ?>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Master List Modal</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table table-responsive">
					<tbody>
						<tr style="display: none;">
							<td><label>ID</label></td>
							<td><input type="text" id="modal_id_original" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Chapter Number</label></td>
							<td><input type="text" id="modal_chap_no" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Chapter Title</label></td>
							<td><input type="text" id="modal_chap_title" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Description</label></td>
							<td><input type="text" id="modal_chap_desc" class="form-control"></td>
						</tr>
						<tr>
							<td><label>Year</label></td>
							<td><input type="text" id="modal_year" class="form-control"></td>
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

<br><div>
	<button name="" id="id_reset" class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal" onclick="reset_modal_content()" type="button">Add Record</button>
</div>
<br><div class="table-responsive" id="">
	<div id="">
		<table class="table table-hover" id="example1" width="100%">
			<thead>
				<tr>
					<th width="10%">ID</th>
					<th width="10%">Chapter #</th>
					<th width="30%">Chapter Title</th>
					<th width="30%">Description</th>
					<th width="10%">Year</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		var live_table = $('#example1').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo base_url('controller_RDIP/controller_rdip_masterlist/getData');?>",
				"type": "post"
			},
			"columns": [
			{
				"class-name": "align-middle",
				"render": function(data, type, row){
					return row["ID"];
				}
			},
			{
				"class-name": "align-middle",
				"render": function(data, type, row){
					return row["Chap_No"];
				}
			},
			{
				"class-name": "align-middle",
				"render": function(data, type, row){
					return row["Chap_Title"];
				},
				"orderable": false
			},
			{
				"class-name": "align-middle",
				"render": function(data, type, row){
					return row["Chap_Desc"];
				},
				"orderable": false
			},
			{
				"class-name": "align-middle",
				"render": function(data, type, row){
					return row["Year"];
				}
			},
			{
				"class-name": "align-middle",
				"render": function(data, type, row){
					return "<button type='button' id='' data-toggle='modal' data-target='#myModal' onclick='pass_rdip_masterlist_credentials(\""+row['ID']+"\",\""+row['Chap_No']+"\",\""+row['Chap_Title']+"\",\""+row['Chap_Desc']+"\",\""+row['Year']+"\")'>Update</button>";
				},
				"orderable": false
			}
			]
		});



		$('#id_btn_add').on('click', function(){
			var chap_no = $('#modal_chap_no').val();
			var chap_title = $('#modal_chap_title').val();
			var chap_desc = $('#modal_chap_desc').val();
			var year = $('#modal_year').val();

			if(chap_no == ''){  
				alert("Enter Chapter Number");  
				return false;  
			}
			if(chap_title == ''){  
				alert("Enter Chapter Title");  
				return false;  
			}
			if(chap_desc == ''){  
				alert("Enter Chapter Description");  
				return false;  
			}
			if(year == ''){  
				alert("Enter Year");  
				return false;  
			}

			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_rdip_masterlist/add_masterlist');?>",
				type: "POST",
				data: { Chap_No:chap_no, Chap_Title:chap_title, Chap_Desc:chap_desc, Year:year },
				dataType: "JSON",
				success: function(data){
					//alert("What a successful insertion!!!");
					if(data.success==true){
						live_table.ajax.reload();

						$('#myModal').modal('hide');
					}
					alert(data.message);
				}
			});
		});

		$('#id_btn_edit').on('click', function(){
			var ID = $('#modal_id_original').val();
			var Chap_No = $('#modal_chap_no').val();
			var Chap_Title = $('#modal_chap_title').val();
			var Chap_Desc = $('#modal_chap_desc').val();
			var Year = $('#modal_year').val();

			if(Chap_No == ''){  
				alert("Enter Chapter Number");  
				return false;  
			}
			if(Chap_Title == ''){  
				alert("Enter Chapter Title");  
				return false;  
			}
			if(Chap_Desc == ''){  
				alert("Enter Chapter Description");  
				return false;  
			}
			if(Year == ''){  
				alert("Enter Year");  
				return false;  
			}

			$.ajax({
				url: "<?php echo base_url('controller_RDIP/controller_rdip_masterlist/update_masterlist');?>",
				type: "POST",
				data: { ID:ID, Chap_No:Chap_No, Chap_Title:Chap_Title, Chap_Desc:Chap_Desc, Year:Year },
				dataType: "JSON",
				success: function(data){
					//alert("Editing success!!!");
					if(data.success==true){
						live_table.ajax.reload();

						$('#myModal').modal('hide');
					}
					alert(data.message);
				}
			});
		});

	});

	function pass_rdip_masterlist_credentials(ID, Chap_No, Chap_Title, Chap_Desc, Year){
		$('#modal_id_original').val(ID);
		$('#modal_chap_no').val(Chap_No);
		$('#modal_chap_title').val(Chap_Title);
		$('#modal_chap_desc').val(Chap_Desc);
		$('#modal_year').val(Year);

		document.getElementById("id_btn_add").hidden = true;
		document.getElementById("id_btn_edit").hidden = false;

		//console.log(Username + " " + Password + " " + Type + " " + Agency + " " + Status);
	}

	function reset_modal_content(){
		$('#modal_id_original').val("");
		$('#modal_chap_no').val("");
		$('#modal_chap_title').val("");
		$('#modal_chap_desc').val("");
		$('#modal_year').val("");

		document.getElementById("id_btn_add").hidden = false;
		document.getElementById("id_btn_edit").hidden = true;
	}
</script>