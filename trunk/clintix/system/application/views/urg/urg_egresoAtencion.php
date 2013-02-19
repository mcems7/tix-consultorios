<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function egresoPaciente()
{
	if( $('estado_salida_v').checked == false && $('estado_salida_m').checked == false )
		alert("Debe seleccionar el estado de salida del paciente!!"); 
	
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
</script>
<h1 class="tituloppal">Servicio de urgencias - Egreso del servicio</h1>
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
    <td class="campo">Fecha y hora ingreso:</td>
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
</table>
</td></tr>
<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla_interna" id="tabla_egreso">
<?php
$num = count($destino);
?>
  <tr>
    <th colspan="2">Egreso del servicio de urgencias</th>
  </tr>
   <tr>
    <td width="40%" class="campo">Estado de salida:</td>
    <td width="60%" class="campo_centro">
      <label>
        <input type="radio" name="estado_salida" id="estado_salida_v" value="VIVO" id="estado_salida_0" />
        Vivo</label>
     &nbsp;
      <label>
        <input type="radio" name="estado_salida" value="MUERTO" id="estado_salida_m" />
        Muerto</label>

   </td>
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
<p><input name="destino" id="destino" type="radio" value="<?=$d['id_destino']?>" />&nbsp;<?=$d['destino']?></p>
  
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
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data).nbs();
echo form_submit('boton', 'Realizar egreso del paciente');
?>
</td></tr>
</table>
</td></tr>
</table>
</center>
<?=form_close();?>
