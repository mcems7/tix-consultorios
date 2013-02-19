<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	return true;	
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	var exValidatorA = new fValidator("formulario");
});
////////////////////////////////////////////////////////////////////////////////
function notificar_ente()
{
	var id_ente = $('id_entidad_ente').value;
	document.location = "<?=site_url('auto/anexo3/anexo3MailEnte/'.$anexo['id_anexo3'])?>/"+id_ente;	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Central de autorizaciones - Anexo técnico No. 3</h1>
<h2 class="subtitulo">Consulta del anexo 3</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Información general del anexo t&eacute;cnico 3</th></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr><td class="campo">Número de informe:</td><td><?php printf("%04d",$anexo['numero_informe']);?></td>
<td class="campo">Fecha:</td><td><?=$anexo['fecha_anexo']?></td>
<td class="campo">Hora:</td><td><?=$anexo['hora_anexo']?></td></tr>
</table>
</td></tr>
<tr><th colspan="2">Entidad a la que se le informa</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Nombre pagador:</td><td><?=$entidad['razon_social']?></td><td class="campo">Código:</td><td><?=$entidad['codigo_eapb']?></td></tr>
</table>
</td></tr>
<tr>
  <th colspan="2">Datos del paciente</th></tr>
<tr><td>
<table width="100%" class="tabla_interna">
<tr>
<td align="center"><?=$tercero['primer_apellido']?></td>
<td align="center"><?=$tercero['segundo_apellido']?></td>
<td align="center"><?=$tercero['primer_nombre']?></td>
<td align="center"><?=$tercero['segundo_nombre']?></td></tr>
<td class="campo_centro">Primer apellido</td><td class="campo_centro">Segundo apellido</td>
<td class="campo_centro">Primer nombre</td><td class="campo_centro">Segundo nombre</td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr><td class="campo">Tipo identificación:</td>
<td><?=$tercero['tipo_documento']?></td>
<td class="campo">Número documento:</td>
<td><?=$tercero['numero_documento']?></td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr><td class="campo">Cobertura en salud:</td><td><?=$paciente['cobertura']?></td></tr>
</table>
</td></tr>
<?php
if($cups != 0)
{
?>
<tr><th colspan="2">Procedimientos y servicios solicitados</th></tr>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
  <tr>
    <td class="campo_centro"><strong>C&oacute;digo CUPS</strong></td>
    <td class="campo_centro"><strong>Cantidad</strong></td>
    <td class="campo_centro"><strong>Descripci&oacute;n</strong></td>
  </tr>
<?php

foreach($cups as $d)
{
	$procedimiento = $this->urgencias_model->obtenerNomCubs($d['cups']);
?>  
  <tr>
    <td style="text-align:center"><?=$d['cups']?>&nbsp;</td>
    <td style="text-align:center"><?=$d['cantidadCups']?>&nbsp;</td>
    <td><?=$procedimiento?>&nbsp;</td>
  </tr>
<?php
}
?> 
</table>
</td></tr>
<?php
}
?>


<tr><th colspan="2">Gestión del anexo t&eacute;cnico 3</th></tr>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top">
    <table width="100%" class="tabla_interna">
  <tr>
    <td class="campo">Estado:</td>
    <td><?=$anexo['estado_anexo']?>
    </td>
     <td class="campo">N&uacute;mero env&iacute;os:</td>
    <td><?=$anexo['numero_envio']?></td>
  </tr>
   <tr>
    <td colspan="4" class="opcion">
      <a href="<?=site_url('auto/anexo3_consulta/anexo3Web/'.$anexo['id_anexo3'])?>" target="_blank"><strong>Consultar anexo t&eacute;cnico 3</strong>
      </a></td></tr>
</table></td>
    <td width="50%">
    <table width="100%" class="tabla_interna">
  <tr>
    <td colspan="2" class="campo_centro">Detalle env&iacute;os&nbsp;</td>
  </tr>
  <tr>
    <td class="campo_centro">Fecha y hora</td>
    <td class="campo_centro">N&uacute;mero env&iacute;o</td>
  </tr>
<?php
	foreach($envios as $d)
	{
?>  
  <tr>
    <td align="center"><?=$d['fecha']?>&nbsp;</td>
    <td align="center"><?=$d['numero_envio']?>&nbsp;</td>
  </tr>
<?php
	}
?>
</table>

    
    </td>
  </tr>
</table>
</td></tr>
<?php
	if($anexo['anexo4'] == 'SI')
	{
?>
<tr><th colspan="2">Listado de anexos 4</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
  <tr>
    <td class="campo_centro">Número autorización</td>
     <td class="campo_centro"><p>Servicios autorizados</p></td>
    <td class="campo_centro">Fecha y hora autorización</td>
    <td class="campo_centro">Fecha y hora de registro</td>
    <td class="campo_centro">Consultar</td>
  </tr>
<?php
	foreach($anexo4 as $d)
	{
	$a4Cups = $this -> autorizaciones_model -> obtenerCupsAnexo4($d['id_anexo4']);
	
?>
<tr>
<td style="text-align:center"><?=$d['numero_informe']?>&nbsp;</td>
<td>
<?php
foreach($a4Cups as $data){
	if($data['cantidadCups'] > 0){
$procedimiento = $this->urgencias_model->obtenerNomCubs($data['cups']);
echo '<li>',$procedimiento,'</li>';
	}
}
?>
</td>
<td style="text-align:center"><?=$d['fecha_anexo']." ".$d['hora_anexo']?>&nbsp;</td>
<td style="text-align:center"><?=$d['fecha']?>&nbsp;</td>
<td class="opcion"><a href="<?=site_url('auto/anexo3_consulta/consultarAnexo4/'.$d['id_anexo4'])?>">Consultar</a></td>
</tr>
<?php
	}
?>
</table>
</td></tr>
<tr><th colspan="2">Gestión de archivos adjuntos</th></tr>
<?php
	}
	if(count($adjuntos) > 0)
	{
?>

<tr><td colspan="2">
<table width="100%" class="tabla_interna">
  <tr>
    <td class="campo_centro">Titulo</td>
    <td class="campo_centro">Descripcion</td>
    <td class="campo_centro">Fecha</td>
    <td class="campo_centro">Tipo</td>
    <td class="campo_centro">Descargar</td>
  </tr>
<?php
	foreach($adjuntos as $dat)
	{
?>
  <tr>
    <td><?=$dat['titulo']?>&nbsp;</td>
    <td><?=$dat['descripcion']?>&nbsp;</td>
    <td><?=$dat['fecha']?>&nbsp;</td>
    <td><?=$dat['ext']?>&nbsp;</td>
    <td class="opcion">
    <a target="_blank" href="<?=base_url()."files/auto/anexo3/adjuntos_anexo3/".$dat['archivo']?>">Descargar</a>
    </td>
    
  </tr>
 <?php
	}
?>
</table>
</td></tr>
 <?php
	}
?>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;

</td></tr>                             
</table>
<?=form_close();?>
