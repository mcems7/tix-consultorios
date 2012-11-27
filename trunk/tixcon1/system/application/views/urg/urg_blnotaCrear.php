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
echo form_open('/urg/bl_enfermeria/crearNotaBlAdm_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">



<tr>
  <td colspan="4" class="campo_centro"> L&iacute;quidos administrados
</td></tr>
<tr>

<td width="25%">V&iacute;a oral</td>
<td width="25%">Sonda nasogástrica</td>
<td width="25%">Líquidos endovenosos</td>

</tr>
<tr>

<td><?=form_input(array('name' => 'via_oral',
							'id'=> 'via_oral',
							'maxlength' => '5',
							'size'=> '5'))?> (mL)</td>
<td><?=form_input(array('name' => 'sng',
							'id'=> 'sng',
							'maxlength' => '5',
							'size'=> '5'))?> (mL)</td>
<td><?=form_input(array('name' => 'liv',
							'id'=> 'liv',
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
