<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
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
	
	var id = $('id_paciente_destino').value;
	if(id == ''){
		alert('Debe especificar a que paciente le va a trasldaras la historia!!');
		return false;
	}
	
	if(confirm('Se realizara el traslado de la atención\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function buscarPacienteTraslado(){
	
	var numd = $('numero_documento').value;
	var numo = $('numero_documento_origen').value;
	if(numd == numo){
		alert("Los documentos de destino y origen no pueden ser iguales!!");
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/traslado_atenciones/buscar_paciente_traslado/'+numd;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('datos_paciente').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Traslado atenci&oacute;n</h1>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/traslado_atenciones/trasladar_atencion_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_paciente_origen',$atencion['id_paciente']);
echo form_hidden('operacion',$operacion);
?>
<center>
<input name="numero_documento_origen" id="numero_documento_origen" type="hidden" value="<?=$tercero['numero_documento']?>" />
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
<td class="campo">Motivo de consulta:</td>
<td colspan="3"><?=$consulta['motivo_consulta']?></td>
</tr>
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
<tr><th colspan="2">Paciente al que se le trasladar&aacute; la atenci&oacute;n</th></tr>
<tr><td class="campo">Número de documento:</td>
<td>
<?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20',
							'value' => '',
							'autocomplete' => 'off',
							'class'=>"fValidate['nit']"))?><?
$data = array(	'name' => 'buscar',
				'id' => 'buscar',
				'onclick' => 'buscarPacienteTraslado()',
				'value' => 'Buscar',
				'type' =>'button');
echo nbs();
echo form_input($data);

?></td></tr>
<tr><td colspan="2" id="datos_paciente">
<input name="id_paciente_destino" id="id_paciente_destino" type="hidden" value="" />
</td></tr>
<tr><td colspan="2" class="mensaje_advertencia">

Advertencia: La información de la atención será cargada al paciente seleccionado, en el caso que el paciente de Origen no tenga otras atenciones, este será eliminado del sistema y su información no podrá ser recuperada en el futuro. Verifique bien la información del paciente de origen y destino antes de realizar el proceso.
</td></tr>
</table>
</td></tr>
<tr><td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
<td class="campo" width="40%">Justificaci&oacute;n traslado:</td>
<td width="60%">
  <textarea name="justificacion" id="justificacion" style="width:100%"  rows="2" class="fValidate['required']"></textarea></td></tr>
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
echo form_submit('boton', 'Trasladar atención');
?>
</td></tr>
</table>
</center>
<?=form_close();?>
