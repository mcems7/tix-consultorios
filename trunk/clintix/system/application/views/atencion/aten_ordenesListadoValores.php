
<select name="lista[<?=$listado[0]['id_clinico']?>]" id="<?=$listado[0]['id_clinico']?>" class="fValidate['required']">
  <option value="">-Seleccione una-</option>
<?php
	foreach($listado as $d)
	{
	echo '<option value="'.$d['descripcion'].'">'.$d['descripcion'].'</option>';
	}
?>
</select>