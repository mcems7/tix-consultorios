<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="35%">Procedimiento y / o servicio:</td><td width="65%">
<input size="60" type="text" id="cups" name="cups" value="" 
onkeyup="ajax_showOptions(this,'util/cups/cupscompletar',event)" AUTOCOMPLETE="off">
<?
$data = array(	'name' => 'ba',
				'onclick' => "avanzado()",
				'value' => 'Búsqueda avanzada',
				'type' =>'button');
echo form_input($data);
?>
<input type="hidden" id="cups_hidden" name="cups_ID">
<input type="hidden" id="flagCups" name="flagCups" value="simple">
</td></tr>
<tr><td colspan="2">
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="20%">Cantidad:</td>
<td width="80%">
<?=form_input(array('name' => 'cantidadCups',
							'id'=> 'cantidadCups',
							'maxlength' => '4',
							'value' => '0',
							'size'=> '4',
							'class'=>"fValidate['integer']"))?></td></tr>
<tr><td class="campo" width="20%">Observaciones:</td>
<td width="80%"><?=form_textarea(array('name' => 'observacionesCups',
							'id'=> 'observacionesCups',
							'rows' => '5',
							'cols'=> '45'))?></td></tr>
</table>
</td></tr>
</table>