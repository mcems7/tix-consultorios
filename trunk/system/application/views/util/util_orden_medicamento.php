<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="20%">Medicamento:</td><td>
<input size="60" type="text" id="atc" name="atc" value="" 
onkeyup="ajax_showOptions(this,'util/ordenes/medicamentos',event)" AUTOCOMPLETE="off">
<input type="hidden" id="atc_hidden" name="atc_ID">
</td><td class="opcion"><a href="<?=site_url('util/ordenes/crearMedicamento')?>" rel="lightbox[external 640 360]" title="Crear medicamento">Crear medicamento</a></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td class="campo_centro">Dosis a medicar</td>
<td class="campo_centro">Medida</td>
</tr>
<tr>
<td class="campo_centro"><?=form_input(array('name' => 'dosis',
						'id'=> 'dosis',
						'maxlength' => '8',
						'size'=> '8',
						'value'=> '0',
						'class'=>"fValidate['real']"))?></td>
<td class="campo_centro"><select name="id_unidad" id="id_unidad">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
	foreach($unidades as $d)
	{
		echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';	
	}
?>
</select></td>
</tr>
<tr>
<td class="campo_centro" width="50%">Frecuencia</td>
<td class="campo_centro" width="50%">Vía administracion</td>
</tr>
<tr>
<td class="campo_centro">Cada: <?=form_input(array('name' => 'frecuencia',
						'id'=> 'frecuencia',
						'maxlength' => '2',
						'size'=> '2',
						'value'=> '0',
						'class'=>"fValidate['integer']"))?>&nbsp;
<select name="id_frecuencia" id="id_frecuencia">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
	foreach($frecuencia as $d)
	{
		echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';	
	}
?>
</select></td>
<td class="campo_centro"><select name="id_via" id="id_via">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
	foreach($vias as $d)
	{
		echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';	
	}
?>
</select></td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="20%">Observaciones:</td>
<td width="80%"><?=form_textarea(array('name' => 'observacionesMed',
							'id'=> 'observacionesMed',
							'rows' => '5',
							'cols'=> '45'))?></td></tr>
</table>
<center>
<?
$data = array(	'name' => 'ba',
				'onclick' => 'agregarMedicamento()',
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center>