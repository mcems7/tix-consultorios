<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
var sMed = null;
var sPro = null;
slideO2 = null;
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
/*window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});*/
////////////////////////////////////////////////////////////////////////////////
function tipoCups(){
	var id_tipo = $('id_tipo').value;
	if(id_tipo == 0)
		return false;
	
	var var_url = '<?=site_url()?>/urg/ordenamiento/cups_urgencias/'+id_tipo;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_cupsUrge').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function agregarMedicamento()
{
	if(!validarMedi())
	{
		return false;
	}
        //alert($('formulario').innerHTML);
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarMedicamento';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_medicamento').get('html');
		$('div_lista_medicamento').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarForm();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function agregarProcecimiento()
{
	if(!validarProce())
	{
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarProcedimiento';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_procedimientos').get('html');
		$('div_lista_procedimientos').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarFormCubs();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function agregarProcecimientoUrg()
{
	var id_tipo = $('id_subcategoriaUrg').value;
	if(id_tipo == 0)
		return false;
		
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarProcedimientoUrg';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario'),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_procedimientos').get('html');
		$('div_lista_procedimientos').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarFormCubs();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
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

function eliminarMedicamento(id_tabla)
{	
	if(confirm('¿Desea eliminar el medicamento seleccionado?'))
		$(id_tabla).dispose();	
}
////////////////////////////////////////////////////////////////////////////////
function validarMedi()
{
	if($('atc_hidden').value < 1 || $('atc').value < 1 ){
		alert("Debe realizar la búsqueda de un medicamento");
		return false;
	}
	
	if($('dosis').value < 1){
		alert("Debe ingresar la dosis a suministrar");
		return false;
	}
	
	if($('id_unidad').value == 0){
		alert("Debe seleccionar una unidad de medica válida");
		return false;
	}
	
	if($('frecuencia').value < 1 || $('id_frecuencia').value == 0){
		alert("Debe diligenciar una frecuencia válida");
		return false;
	}
	
	if($('id_via').value == 0){
		alert("Debe seleccionar una vía de administración válida");
		return false;
	}
	
	return true;
	
}
////////////////////////////////////////////////////////////////////////////////
function validarProce()
{
	if($('cups_hidden').value < 1 ){
		alert("Debe seleccionar un procedimiento");
		return false;
	}
	
	if($('cantidadCups').value == 0){
		alert("Debe seleccionar una cantidad procedimientos solicitada");
		return false;
	}
	
	return true;
	
}
///////////////////////////////////////////////////////////////////////////////
function eliminarCups(id_tabla)
{	
	if(confirm('¿Desea eliminar el procedimiento o servicio seleccionado?'))
	{
		$(id_tabla).dispose();
	}
}
////////////////////////////////////////////////////////////////////////////////
function borrarForm()
{	
	$('atc_hidden').value = '';
	$('atc').value = '';
	$('dosis').value = '0';
	$('id_unidad').selectedIndex = '0';
	$('id_frecuencia').selectedIndex = '0';
	$('frecuencia').value = '0';
	$('id_via').selectedIndex = '0';
	$('observacionesMed').value = '';
}
////////////////////////////////////////////////////////////////////////////////
function borrarFormCubs()
{
	var flag = $('flagCups').value;
	if(flag == 'simple'){
		$('cups_hidden').value = '';
		$('cups').value = '';
		
	}else if(flag == 'avanzado'){
		simple();
	}
}
////////////////////////////////////////////////////////////////////////////////
function avanzado()
{
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsAvanzados';
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('agregarPro').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function simple()
{
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsSimple';
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('agregarPro').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/atencion/atenciones/registrar_orden',$attributes);
echo form_hidden('id_atencion',$tercero['id']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('fecha_ini_ord',date('Y-m-d H:i:s'));
?>
<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Nueva orden médica</h2>
<center><h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Nueva orden médica</h2>
<table width="95%" class="tabla_form">

<?php $this->load->view('atencion/aten_datos_basicos_atencion');?>
<tr>
  <th colspan="2" id="mosAgrMed">Medicamentos</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_medicamento">
  
  </div>
  </td></tr>
<tr>
  <td colspan="2">
  <?=$this->load->view('urg/urg_ordAgreMedicamento',$med)?>
  </td></tr>
<tr>
  <th colspan="2" id="mosAgrPro">Procedimientos y ayudas diagnosticas</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">
  
  </div>
  </td></tr>
  <tr><td colspan ='2'>
  <center>
<?
$data = array(	'name' => 'ba',
				'onclick' => 'agregarProcecimientoUrg()',
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center></td>
  </tr>
  <tr><td colspan="2" class="linea_azul"></td></tr> 
  <tr>
  <td colspan="2">
  <div id="agregarPro">
  <?=$this->load->view('urg/urg_ordAgreProcSimple')?>
  </div>
  <center>
<?
$data = array(	'name' => 'ba',
				'onclick' => 'agregarProcecimiento()',
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center>
  </td></tr>
<tr>
<?php
	if($medico['id_tipo_medico'] == '1')
	{
?>
<tr><td colspan="2" id="div_verificar">
<?=$this->load->view('urg/urg_ordConfirm')?>
</td></tr>
<?php
	}else{
		echo form_hidden('verificado','SI');
		echo form_hidden('id_medico_verifica',$medico['id_medico']);
		echo form_hidden('fecha_verificado',date('Y-m-d H:i:s'));
	}
?>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'history.back()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />

</td></tr></table>
<?=form_close();?>