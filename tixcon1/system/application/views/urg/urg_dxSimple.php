<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="35%">Diagnostico:</td><td width="65%">
<input size="60" type="text" id="dx" name="dx" value="" 
onkeyup="ajax_showOptions(this,'urg/atencion_inicial/diagnosticos',event)" AUTOCOMPLETE="off">
<?
$data = array(	'name' => 'ba',
				'onclick' => "avanzado()",
				'value' => 'Búsqueda avanzada',
				'type' =>'button');
echo form_input($data);
?>
<input type="hidden" id="dx_hidden" name="dx_ID">
</td></tr>
</table>