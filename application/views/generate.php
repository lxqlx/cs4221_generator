<h2><?php echo $title ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('datagenerator') ?>

	<label for='datatype1'> Type1 </label>
	<input type='input' name='datatype1' value='name'/><br />

	<label for='datatype2'> Type2 </label>
	<input type='input' name='datatype2' value='country'/><br />

	<label for='datatype3'> Type3 </label>
	<input type='input' name='datatype3' value='email'/><br />

	<label for='datatype4'> Type4 </label>
	<input type='input' name='datatype4' value='phone'/><br />

	<label for='datatype5'> Type5 </label>
	<input type='input' name='datatype5' value='birthdate'/><br />

	<label for='datatype6'> Type6 </label>
	<input type='input' name='datatype6' value='salary'/><br />

	<input type='submit' name='submit' value='Generate Data' />

</form>
