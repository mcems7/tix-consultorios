<script type="text/javascript">////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
 var exValidatorA = new fValidator("formulario");		 
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	
	if(confirm('Se realizara la apertura de la atención del paciente\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Apertura de una atención finalizada</h1>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/abrir_atencion/abrirAtencion',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_estado',$id_estado);
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
  <tr>
    <td class="campo">Fecha y hora egreso:</td>
    <td><?=$atencion['fecha_egreso']?>&nbsp;</td>
     <td class="campo">Servicio:</td>
    <td><?=$atencion['nombre_servicio']?>&nbsp;</td>
    </tr>
</table>
</td></tr>
<tr><td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo" width="50%">Justificaci&oacute;n apertura atenci&oacute;n:</td>
<td width="50%">
<?=form_textarea(array('name' => 'motivo',
								'id'=> 'motivo',
								'class'=> "fValidate['required']",
								'rows' => '3',
								'cols'=> '50'))?>
</td></tr>
<tr>
<td class="campo">Nombre de usuario:</td>
<td><?= $usuario['_username']; ?></td>
</tr>
<tr>
<td class="campo">Contrase&ntilde;a:</td>
<td>
<?=form_password(array('name' => 'password',
					'id'=> 'password',
					'maxlength' => '20',
					'size'=> '20',
					'class'=>"fValidate['required']"))?>
		
	
		
		</td>
	</tr>
</table>
</td></tr>
<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<?php
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
echo form_submit('boton', 'Abrir atención');
?>
</td></tr>
</table>
</center>
<?=form_close();?>
