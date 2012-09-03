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
<tr><td colspan="2" class="opcion">
<?php
	if($ordenes != 0)
	{
?>
<a href="<?=site_url()?>/urg/ordenamiento/crearOrdenEdit/<?=$atencion['id_atencion']?>">Registrar una orden médica</a>
<?php
	}else{
?>
<a href="<?=site_url()?>/urg/ordenamiento/crearOrden/<?=$atencion['id_atencion']?>">Registrar una orden médica</a>
<?php
	}
?>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Ordenes realizadas</th></tr>
<tr>
<td>
<div id="con_ord">

</div>
<?php
	if($ordenes == 0)
	{
		echo "<center><strong>No se ha registrado ninguna orden médica</strong></center>";	
	}else{
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Fecha y hora</td>
    <td class="campo_centro">Medico</td>
    <td class="campo_centro">Especialidad</td>
    <td class="campo_centro">Insumos</td>
    <td class="campo_centro">Despacho</td>
    <td class="campo_centro">Operación</td>
  </tr>
<?php
	foreach($ordenes as $d)
	{
?>
  <tr>
<td><?=$d['fecha_creacion'];?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['esp'];?></td>
<td style="text-align:center"><?=$d['insumos'];?></td>
<td style="text-align:center"><?=$d['insumos_despacho'];?></td>
<?php 
if($d['verificado'] == 'NO'){ ?>
<td class="opcion"><a href="<?=site_url('urg/ordenamiento/verificarOrdenEdit/'.$d['id_atencion'])?>"><strong>Verificar</strong></a></td>
<?php } 
else { ?>
<td class="opcion"><a href="<?=site_url('urg/ordenamiento/consultarOrden/'.$d['id_orden'])?>"><strong>Consultar</strong></a></td>
</tr> <?php } ?> 
<?php
	}
		echo "</table>";
	}
?>

</td>
</tr>
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
</table>
</center>
