<?=form_hidden('id_tercero',$tercero['id_tercero'])?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2"><span class="boton_guardar">
<a href="#" onclick="editarTerceroGuardar()">&nbsp;Guardar</a></span>
</td></tr>
<tr><td width="40%">Primer apellido:</td>
<td width="60%">
<?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'class'=>"fValidate['alphanumtilde']",
					'maxlength'   => '20',
					'value' => $tercero['primer_apellido'],
					'size'=> '20'))?></td></tr>
<tr><td>Segundo apellido:</td><td>
<?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20','size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => $tercero['segundo_apellido']))?></td></tr>
<tr><td>Primer nombre:</td><td>
<?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'value' => $tercero['primer_nombre'],
					'class'=>"fValidate['alphanumtilde']"))?></td></tr>
<tr><td>Segundo nombre:</td><td>
<?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => $tercero['segundo_nombre']))?></td></tr>
<tr><td>Tipo documento:</td><td>
<select name="id_tipo_documento" id="id_tipo_documento">
<option value="0">-Seleccione uno-</option>
<?
foreach($tipo_documento as $d)
{
	if($tercero['id_tipo_documento'] == $d['id_tipo_documento'])
	{
		echo '<option value="'.$d['id_tipo_documento'].'" selected="selected">'.$d['tipo_documento'].'</option>';
	}else{
		echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';	
	}
}
?>
</select>
</td></tr>
<tr><td>Número de documento:</td><td>
<?=form_input(array('name' => 'numero_documento',
					'id'=> 'numero_documento',
					'maxlength'   => '20',
					'size'=> '20',
					'value' => $tercero['numero_documento'],
					'class'=>"fValidate['nit']"))?></td></tr>
<tr><td>Fecha de nacimiento:</td>
<td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?=$tercero['fecha_nacimiento']?>" size="10" maxlength="10" class="fValidate['dateISO8601']">
&nbsp;(aaaa-mm-dd)</td></tr>
</table>