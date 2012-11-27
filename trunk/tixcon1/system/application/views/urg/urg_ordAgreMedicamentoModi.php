<table class="tabla_registro" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<?=form_hidden('atcModi',$medicamento['atc']);?>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="20%">Medicamento:</td><td width="80%">
<?=$nomMedi?>
</td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td class="campo_centro">Dosis a medicar</td>
<td class="campo_centro">Medida</td>
</tr>
<tr>
<td class="campo_centro"><?=form_input(array('name' => 'dosisModi',
						'id'=> 'dosisModi',
						'maxlength' => '8',
						'size'=> '8',
						'value'=> $medicamento['dosis'],
						'class'=>"fValidate['real']"))?></td>
<td class="campo_centro"><select name="id_unidadModi" id="id_unidadModi">
<option value="0">-Seleccione uno-</option>
<?php
	foreach($unidades as $d)
	{
		if($medicamento['id_unidad'] == $d['id']){
			echo '<option value="'.$d['id'].'" selected="selected">'.$d['descripcion'].'</option>';
		}else{
			echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';
		}
	}
?>
</select></td>
</tr>
<tr>
<td class="campo_centro" width="50%">Frecuencia</td>
<td class="campo_centro" width="50%">Vía administracion</td>
</tr>
<tr>
<td class="campo_centro">Cada: <?=form_input(array('name' => 'frecuenciaModi',
						'id'=> 'frecuenciaModi',
						'maxlength' => '2',
						'size'=> '2',
						'value'=> $medicamento['frecuencia'],
						'class'=>"fValidate['integer']"))?>&nbsp;
<select name="id_frecuenciaModi" id="id_frecuenciaModi">
<option value="0">-Seleccione uno-</option>
<?php
	foreach($frecuencia as $d)
	{
		if($medicamento['id_frecuencia'] == $d['id']){
			echo '<option value="'.$d['id'].'" selected="selected">'.$d['descripcion'].'</option>';	
		}else{
			echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';	
		}
	}
?>
</select></td>
<td class="campo_centro"><select name="id_viaModi" id="id_viaModi">
<option value="0">-Seleccione uno-</option>
<?php
	foreach($vias as $d)
	{
		if($medicamento['id_via'] == $d['id']){
			echo '<option value="'.$d['id'].'" selected="selected">'.$d['descripcion'].'</option>';	
		}else{
			echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';	
		}
	}
?>
</select></td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="20%">Observaciones:</td>
<td width="80%"><?=form_textarea(array('name' => 'observacionesMedModi',
							'id'=> 'observacionesMedModi',
							'rows' => '5',
							'value' => $medicamento['observacionesMed'],
							'cols'=> '45'))?></td></tr>
</table>
<center>
<?
$data = array(	'name' => 'ba',
				'onclick' => "agregarMedicamentoModi('".$marca."')",
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center>
</td></tr></table>