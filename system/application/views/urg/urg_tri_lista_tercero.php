<script language="javascript">
window.addEvent("domready", function(){
 slideLis = new Fx.Slide('lista_terceros');		 
});
</script>
<br />
<p align="justify">Se han encontrado los siguientes terceros con datos similares a los ingresados, verifique que el tercero que desea ingresar como paciente no esté en la lista.</p>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<th>Operación</th>
<th>Apellidos</th>
<th>Nombres</th>
<th>Documento de identidad</th>
<tr>
<?php
foreach($lista as $d)
{
?>
<tr>
<td><?
$data = array(	'name' => 'ter',
				'onclick' => "terceroConfirmado('".$d['id_tercero']."')",
				'value' => 'Confirmar tercero',
				'type' =>'button');
echo form_input($data);
?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']?></td>
<td><?=$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['tipo_documento'].": ".$d['numero_documento']?></td>
<tr>
<?php	
}
?>
<tr><td colspan="4"><center>
<?
$data = array(	'name' => 'ter',
				'onclick' => 'terceroNolista()',
				'value' => 'El tercero no esta en la lista',
				'type' =>'button');
echo form_input($data);
?>
</center></td></tr>
</table>
<br />
<br />
<br />