<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
var sMed = null;
var sPro = null;
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
function agregarInsumo()
{
	if(!validarInsumo())
	{
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/insumos/agregarInsumo';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_insumos').get('html');
		$('div_lista_insumos').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarFormInsumos();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function validarInsumo()
{
	if($('insumo_hidden').value < 1 ){
		alert("Debe seleccionar un insumo");
		return false;
	}
	
	if($('cantidad').value < 1 ){
		alert("Debe indicar la cantidad del insumo");
		return false;
	}
	return true;
}
////////////////////////////////////////////////////////////////////////////////
function borrarFormInsumos()
{
		$('insumo_hidden').value = '';
		$('insumo').value = '';
		$('cantidad').value = '0';
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Solicitud de insumos</h1>
<h2 class="subtitulo">Consultar orden médica</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
                    'name'     => 'formulario',
                    'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/insumos/crearOrdenInsumosIndepe_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('fecha_ini_ord',date('Y-m-d H:i:s'));
?>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo">Fecha y hora de la orden:</td><td><?=date('Y-m-d H:i:s')?></td></tr>
<tr><td class="campo" width="30%">Quien ordena:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr>
  <th colspan="2" id="mosAgrIns">Insumos Y Dispositivos</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_insumos">
  
  </div>
  </td></tr>
<tr>
  <td colspan="2">
  <?=$this->load->view('urg/urg_ordAgreInsumo')?>
  </td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(  'name' => 'bv',
        'onclick' => 'regresar()',
        'value' => 'Volver',
        'type' =>'button');
echo form_input($data);
?>&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
</td></tr></table>
<?=form_close();?>
