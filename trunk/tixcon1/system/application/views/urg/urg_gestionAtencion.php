<script type="text/javascript">
var sEgre = null;
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 
	sEgre = new Fx.Slide('div_egreso');
	sEgre.hide();
	
});
////////////////////////////////////////////////////////////////////////////////
function mostrarEgreso()
{
	var admision = '<?=$atencion['admision']?>';
	if(admision == 'NO'){
		alert("Para realizar la acción solicitada la consulta inicial debe estar verificada");
		return false;
	}
	sEgre.toggle();	
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function egresoPaciente()
{
	for(i=0; i <document.formulario.destino.length; i++){
    if(document.formulario.destino[i].checked){
      var val = document.formulario.destino[i].value;}
    }
    if(val == undefined){
    alert('Debe seleccionar el destino de egreso del paciente!!');
    return false;
	}
	
	var valor = $('destino').value;
	if(valor == 2){
		alert("El paciente sera enviado a la sala de espera de observacion");	
	}
	
	if(!confirm("¿Esta seguro que desea realizar el egreso del paciente?"))
	{
		return false;	
	}else{
		return true;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function verificado()
{
	alert("Para realizar la acción solicitada la consulta inicial debe estar verificada");	
}
////////////////////////////////////////////////////////////////////////////////
function admision(){
	alert("No se ha realizado el ingreso administrativo del paciente!!\nNo se permite realizar la acción.");
	return false;
}
///////////////////////////////////////////////////////////////////////////////
function gineco()
{
	alert("El servicio en el que se encuentra la paciente no permite remitir a observación!!");
	return false;
}
///////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Gesti&oacute;n de la atención</h1>
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
	echo ' - <strong>',$atencion['ingreso'], '</strong>';
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
  <?php
	$clas = "";
	if($atencion['clasificacion'] == 1){
		$clas = 'class="triage_rojo_con"';
	}else if($atencion['clasificacion'] == 2){
		$clas = 'class="triage_amarillo_con"';
	}else if($atencion['clasificacion'] == 3){
		$clas = 'class="triage_verde_con"';
	}else if($atencion['clasificacion'] == 4){
		$clas = 'class="triage_blanco_con"';
	}
	
?>
    <td class="campo">Clasificación TRIAGE:</td>
    <td <?=$clas?> style="padding:10px; text-align:left;"><?=$atencion['clasificacion']?>&nbsp;</td>
  </tr>
  <tr>
    <td class="campo">Motivo de consulta:</td>
    <td colspan="3"><?=$consulta['motivo_consulta']?>&nbsp;</td>
  </tr>
  <tr>
  <td class="campo">Diagn&oacute;sticos consulta inicial:</td>
  <td colspan="3">
  
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
    <tr>
  <td class="campo">Diagn&oacute;sticos evoluciones:</td>
  <td colspan="3">
  
  <?php
if(count($dxEvo) > 0)
{
	foreach($dxEvo as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a las evoluciones';

}
?>
  </td></tr>
</table>

</td>
</tr>
<?php
if(count($inter) > 0)
{
?>
<tr><th colspan="2" id="opciones">Interconsultas</th></tr>
<tr><td colspan="2">
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora solicitud</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
	$i = 1;
	foreach($inter as $d)
	{

?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_solicitud']?></td>
<td><?=$d['estado']?></td>
<td class="opcion"><a href="<?=site_url()?>/urg/evoluciones/respInterconsultaUrg/<?=$d['id_interconsulta']?>/<?=$atencion['id_atencion']?>"><strong>Responder</strong></a></td>

<?php
$i++;
}
?>
</table>
</td></tr>
<?php
}
?>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
  <tr>
    <td class="opcion"><a href="<?=site_url()?>/urg/gestion_atencion/consultaTriage/<?=$atencion['id_atencion']?>">Consultar<br />TRIAGE</a></td>
    <td class="opcion"><a href="<?=site_url()?>/urg/gestion_atencion/consultaAtencion/<?=$atencion['id_atencion']?>">Consultar<br /> Atención inicial</a></td>
    <td class="opcion">
<?php
	if($consulta['verificado'] == 'SI')
	{
   if($ultima_evolucion == 'NO' && $ultima_evolucion != '0'){
   echo '<div style="background-color:#F00">Pendiente verificar</div>';
  } ?>
   <a href="<?=site_url()?>/urg/evoluciones/main/<?=$atencion['id_atencion']?>">Evoluciones</a>
<?php
	}else{
?>
	<a href="#opciones" onclick="verificado()">Evoluciones</a>
<?php
	}
?>  
</td>
<td class="opcion">
<?php
 if($atencion['admision'] == 'SI'){
	 
	if($consulta['verificado'] == 'SI')
	{
?> 
<a href="<?=site_url()?>/urg/ordenamiento/main/<?=$atencion['id_atencion']?>">Ordenes procedimientos y formulación</a>
<?php if($ultima_orden['verificado'] == 'NO'){
    echo '<div style="background-color:#F00">Pendiente verificar</div>';
        } 
	} else {
?>
	<a href="#opciones" onclick="verificado()">Ordenes procedimientos y formulación</a>
<?php
	}
}else{
?>
<a href="#opciones" onclick="admision()">Ordenes procedimientos y formulación</a>
<?php
}
?>
</td>
<td class="opcion">
<?php
	if($consulta['verificado'] == 'SI' && $atencion['admision'] == 'SI')
	{
?> 
    <a href="<?=site_url()?>/urg/observacion/crearOrden/<?=$atencion['id_atencion']?>">Remitir a observación</a>
<?php
	}else if($consulta['verificado'] == 'NO'){
?>
	<a href="#opciones" onclick="verificado()">Remitir a observación</a>
<?php
	}else if($atencion['admision'] == 'NO'){
?>
<a href="#opciones" onclick="admision()">Remitir a observación</a>
<?php
	}
?>
</td>
    <td class="opcion">
<?php
	if($consulta['verificado'] == 'SI')
	{
?>
	<a href="#tabla_egreso" onclick="mostrarEgreso()">Egreso del servicio de urgencias</a>
<?php
	}else{
?>
	<a href="#opciones" onclick="verificado()">Egreso del servicio de urgencias</a>
<?php
	}
?>    
    </td>
  </tr>
</table>
</td>
</tr>
<tr><td colspan="2">
<div id="div_egreso">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla_interna" id="tabla_egreso">
<?php
$num = count($destino);
?>
  <tr>
    <th colspan="2">Egreso del servicio de urgencias</th>
  </tr>
  <tr>
    <td width="40%" class="campo_centro">Destino del paciente</td>
    <td width="60%" class="campo_centro">Observaciones sobre el destino</td>
  </tr>
  <tr><td>
<?php
	foreach($destino as $d)
	{
?>	
<li><input name="destino" id="destino" type="radio" value="<?=$d['id_destino']?>" />&nbsp;<?=$d['destino']?></li>
  
<?php
	}
?>
</td>
<td>
<?=form_textarea(array('name' => 'obser_destino',
							'id'=> 'obser_destino',
							'rows' => '5',
							'cols'=> '40'))?>
</td>
</tr>
<tr><td colspan="2" align="center">

<?=form_submit('boton', 'Realizar egreso del paciente')?>
</td></tr>
</table>
</div>
</td></tr>
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
