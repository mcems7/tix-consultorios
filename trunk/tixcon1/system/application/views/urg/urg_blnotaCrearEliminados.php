<script type="text/javascript">
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
 
});
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
</script>

<center>


<tr><td>

<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/bl_enfermeria/crearNotaBlElimi_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">



<tr>
  <td colspan="9" class="campo_centro"> L&iacute;quidos Eliminados
</td></tr>
<tr>
<td width="11%">Orina</td>
<td width="11%">Deposici&oacute;n</td>
<td width="11%">Vómito</td>
<td width="11%">S.N.G.</td>
<td width="11%">Dren (D)</td>
<td width="11%">Dren (E)</td>
<td width="11%">Sello a tórax (D)</td>
<td width="11%">Sello a tórax (E)</td>
<td width="11%">Otros</td>

</tr>
<tr>
<td><?=form_input(array('name' => 'orina',
							'id'=> 'orina',
							'maxlength' => '5',
							'size'=> '5',
							))?> (mL)</td>


<td><?=form_input(array('name' => 'deposicion',
							'id'=> 'deposicion',
							'maxlength' => '5',
							'size'=> '5'))?> (mL)</td>
<td><?=form_input(array('name' => 'vomito',
							'id'=> 'vomito',
							'maxlength' => '5',
							'size'=> '5'))?> (mL)</td>
<td><?=form_input(array('name' => 'sng',
							'id'=> 'sng',
							'maxlength' => '5',
							'size'=> '5' ))?> (mL)</td>
<td><?=form_input(array('name' => 'drend',
							'id'=> 'drend',
							'maxlength' => '5',
							'size'=> '5' ))?> (mL)</td>
<td><?=form_input(array('name' => 'drene',
							'id'=> 'drene',
							'maxlength' => '5',
							'size'=> '5' ))?> (mL)</td>
<td><?=form_input(array('name' => 'storaxd',
							'id'=> 'storaxd',
							'maxlength' => '5',
							'size'=> '5' ))?> (mL)</td>
<td><?=form_input(array('name' => 'storaxe',
							'id'=> 'storaxe',
							'maxlength' => '5',
							'size'=> '5' ))?> (mL)</td>
<td><?=form_input(array('name' => 'otros',
							'id'=> 'otros',
							'maxlength' => '5',
							'size'=> '5' ))?> (mL)</td>                            
                            <tr>

<tr><td colspan="6" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data);
?>

&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
<?=form_close();?>
</td></tr>
