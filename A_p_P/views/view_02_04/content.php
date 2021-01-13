
<?php echo validation_errors(); ?>

<?php echo form_open('controller_02_04/add_stud'); ?>

	<div>
		<label>pogi ako</label>
	</div>
	<div>
		<input type="text" name="id" />
		<button type="submit" name="Search">Search Student</button><br><br>
		<input type="text" name="fname" /><br>
		<input type="text" name="lname" /><br>
		<button type="submit" name="Add">Add Student</button><br>
	</div>
</form>