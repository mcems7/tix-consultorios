<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
});
////////////////////////////////////////////////////////////////////////////////
function egreso(){
	if(confirm("¿Está seguro de realizar el egreso del paciente?"))
	{
		document.location ="<?=site_url('hosp/hosp_gestion_atencion/egreso_paciente')."/".$atencion['id_atencion'];?>";
	}else{
		return false;
	}
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
///////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Hospitalización - Gesti&oacute;n de la atención</h1>
<h2 class="subtitulo">Informaci&oacute;n de la atenci&oacute;n</h2>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
	               'onsubmit' => 'return egresoPaciente()',
					'method'   => 'post');
echo form_open('/urg/gestion_atencion/egresoUrgencias',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
?>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
<td class="campo">Ingreso administrativo:</td>
<td><?php
echo $atencion['admision'];
if($atencion['admision'] == 'SI')
{
	echo ' - <strong>',$atencion['numero_ingreso'], '</strong>';
}
?></td></tr>
</table>
</td>
</tr>

<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
  <tr>
    <td class="campo">Fecha y hora de ingreso:</td>
    <td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
    <td class="campo">Servicio:</td>
    <td><?=$atencion['nombre_servicio']?>&nbsp;</td>
     <td class="campo">Cama:</td>
    <td><?=$atencion['cama']?>&nbsp;</td>
  </tr>
  <tr>
  <td class="campo">Diagn&oacute;sticos atenci&oacute;n:</td>
  <td colspan="5"> 
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta inicial';

}
?>
  </td></tr>
</table>
</td>
</tr>
<tr><th colspan="2" id="opciones">Gestión de autorizaciones</th></tr>
<td class="opcion" colspan="2"><a href="<?=site_url('auto/anexo3/anexo3Hosp/'.$d['id_atencion'])?>"><strong>Generar Anexo T&eacute;cnico 3</strong></a></td>
<?php
if($anexo3 !=0){
?>
<tr><td colspan="2">

<?php
	$d['lista'] = $anexo3;
	$this->load->view('auto/auto_listadoAnexo3',$d);

?>
</td></tr>
<?php
}
?>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
  <tr>
   <td class="opcion">
	<a href="<?=site_url('hosp/hosp_gestion_atencion/editar_atencion/'.$d['id_atencion'])?>">Editar información de la atención</a>
    </td>
    <td class="opcion">
	<a href="#" onclick="egreso()">Egreso del servicio</a>
    </td>
  </tr>
</table>
</td>
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
<?=form_close();?>
