<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function resetDiv()
{
	$('con_evo').set('html','');
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Ordenamiento médico</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Ordenes realizadas</th></tr>
<tr>
<td>
<div id="con_ord">

</div>
<?php
	if($ordenes == 0)
	{
		echo "<center><strong>No se ha generado ningun resultado de laboratorio</strong></center>";	
	}else{
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
	<td class="campo_centro">No Orden</td>
    <td class="campo_centro">Fecha y hora</td>
    <td class="campo_centro">Procedimiento</td>
    <td class="campo_centro">Operacion</td>
    
  
  </tr>
<?php

	foreach($ordenes as $d)
	{
?>
  <tr>
<td align="center"><?=$d['id_ordenes'];?></td>
<td><?=$d['fecha_realizado'];?></td>
<td><?=$d['cups'];?></td>


<td class="opcion"><a href="<?=site_url('lab/hce_laboratorio/interpretarOrdenLab/'.$d['id_ordenes'].'/'.$id_atencion['id_atencion'])?>"><strong>Ver</strong></a></td>
</tr> 
<?php
	}
		echo "</table>";
	}
?>


<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</td>
</table>