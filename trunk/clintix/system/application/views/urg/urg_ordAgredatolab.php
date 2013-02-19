
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="20%">Cantidad:</td>
<td width="80%">
<?=form_input(array('name' => 'cantidadCupsLab',
							'id'=> 'cantidadCupsLab',
							'maxlength' => '4',
							'value' => '1',
							'size'=> '4'    ))?></td></tr>
<tr>
<td class="campo">Frecuencia:</td>
<td>Cada: <?=form_input(array('name' => 'frecuencia_lab',
						'id'=> 'frecuencia_lab',
						'maxlength' => '2',
						'size'=> '2',
						'value'=> '0'
						))?>&nbsp;
<select name="id_frecuencia_lab" id="id_frecuencia_lab">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
	foreach($med['frecuencia'] as $d)
	{
		echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';	
	}
?>
</select></td>



</tr>

</table>
