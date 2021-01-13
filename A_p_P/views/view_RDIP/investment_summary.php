<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<?php 	echo validation_errors(); 
require 'navbar_admin.php'; ?>

<label>Investment Summary</label>
<div>
	<select title="Year Range" class="form-control" id="year" style="width:10%;">
		<?php 
		foreach ($year as $row) {
			echo "<option value='".$row->Year."'>".$row->Year."</option>";
		}
		?>
	</select>
</div><br>
<div title="Chapters" id="chapters" style="width:95%; margin:auto;">
</div>
<script type="text/javascript">
	$(document).ready(function () {

		//load investment summary w/o trigger
		$.ajax({
			url: "<?php echo base_url('controller_RDIP/controller_investment_summary/alvin');?>",
			type: "POST",
			data: { Year:$('#year').val() },
			dataType: "text",
			success: function(data){
				$('#chapters').html(data);
			}
		});

   		//
   		$('#id_chapters').dataTable( {
   			"searching": true,
   			"bStateSave": true,
   			"bProcessing": true,
   			"paging": false,
   			"bInfo": false
   		} );
   		//

   		//load investment summary w/ trigger
   		$('#year').on('change', function(){
   			$.ajax({
   				url: "<?php echo base_url('controller_RDIP/controller_investment_summary/alvin');?>",
   				type: "POST",
   				data: { Year:$('#year').val() },
   				dataType: "text",
   				success: function(data){
   					$('#chapters').html(data);
   				}
   			});
   		});

   	});
   </script>