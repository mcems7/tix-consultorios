<?=$this -> load -> view("core/tabla_dinamica.js.php");?>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
var sMed = null;
var sPro = null;
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
slideO2 = null;
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
	
	slideO2 = new Fx.Slide('div_oxigeno');
	slideO2.hide();
	
	tipoOxigeno('<?=$orden['oxigeno']?>');
	
});
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
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function agregarDieta()
{	
	var id = $('id_dieta_').value;
	
	if(id == 0){
		alert('Debe seleccionar una dieta de la lista!!');
		return false;	
	}
	
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarDieta';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_dietas').get('html');
		$('div_lista_dietas').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarForm();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function eliminarDieta(id_tabla)
{	
	if(confirm('¿Desea eliminar la dieta seleccionada?'))
		$(id_tabla).dispose();	
}
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
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();	
}

///////////////////////////////////////////////////////
function tiposs(){
	var id_tipo = $('id_tipo').value;
	
	if(id_tipo == 0)
		return false;
	
	var var_url = '<?=site_url()?>/urg/ordenamiento/cups_datolab/'+id_tipo;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_cupsLab').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		
						
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();	
}







////////////////////////////////////////////////////////////////////////////////
function tipoOxigeno(valor)
{
	if(valor == 'SI'){
		slideO2.slideIn();
	}else if(valor == 'NO'){
		slideO2.slideOut();
	}
}
////////////////////////////////////////////////////////////////////////////////
function saturacionOxigeno()
{	
	var var_url = '<?=site_url()?>/urg/ordenamiento/tipoOxigeno';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('tipo_oxigeno').set('html', html);},
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
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
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
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function agregarCuidado()
{
	if(!validarCuidado())
	{
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarCuidado';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_cuidados').get('html');
		$('div_lista_cuidados').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarFormCubs();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
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
function eliminarMedicamentoMod(id_tabla)
{	
		var html = '<input type="hidden" value="Quitar" name="bandera[]"><strong>Modificado</strong>';
		$(id_tabla).set('html',html);	
}
////////////////////////////////////////////////////////////////////////////////
function suspenderMedicamentoMod(id_tabla)
{	
		var html = '<input type="hidden" value="Suspendido" name="bandera[]"><strong>Suspendido</strong>';
		$(id_tabla).set('html',html);	
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
	
	return true;
	
}
////////////////////////////////////////////////////////////////////////////////
function validarCuidado()
{
	if($('id_cuidado').value == 0 ){
		alert("Debe seleccionar un cuidado de enfermería");
		return false;
	}
	
	if($('id_frecuencia_cuidado').value == 0 ){
		alert("Debe seleccionar la frecuencia del cuidado de enfermería");
		return false;
	}
	
	return true;	
}
////////////////////////////////////////////////////////////////////////////////
function eliminarCups(id_tabla)
{	
	if(confirm('¿Desea eliminar el procedimiento o servicio seleccionado?'))
	{
		$(id_tabla).dispose();
	}
}
////////////////////////////////////////////////////////////////////////////////
function eliminarCuidado(id_tabla)
{
	if(confirm('¿Desea eliminar el cuidado de enfermería seleccionado?'))
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
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
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
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function modificarMed(id,accion,marca){
	
	$('div_lista_medicamento_modi').set('html','');
	
	var objeto = "opcionMed"+id;
	var elementos = document.getElementsByName(objeto);
	
	
	var id_tabla = "tmc"+marca;
	if(accion == 'Modificar')
	{
		
		if(confirm("¿Está seguro de querer modificar la dosis del medicamento?"))
		{
			
						
	var var_url = '<?=site_url()?>/urg/ordenamiento/consultaMedicaModi/'+id+'/<?=$orden['id_orden']?>/'+marca;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		$('div_lista_medicamento_modi').set('html',html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){	
		window.location.hash = "div_lista_medicamento";
		
		 },
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();	
	
			
		}else{
	
 
  for (i=0;i<elementos.length;i++){
    if(elementos[i].value == 'Modificar')
		elementos[i].checked = false;
	
	  if(elementos[i].value == 'Continuar')
		elementos[i].checked = true;	
  }
 
				
			return false;
		}
	}else if(accion == 'Suspender'){
		if(confirm("¿Está seguro de querer suspender el medicamento?"))
		{
			suspenderMedicamentoMod(id_tabla);
			return true;
		}else{
			  for (i=0;i<elementos.length;i++){
			if(elementos[i].value == 'Suspender')
				elementos[i].checked = false;
			
			  if(elementos[i].value == 'Continuar')
				elementos[i].checked = true;	
		  }	
		  
		
		  return false;
		}
	}
 
}
////////////////////////////////////////////////////////////////////////////////
function agregarMedicamentoModi(marca){
	var id_tabla = "tmc"+marca;
	
	if($('dosisModi').value < 1){
		alert("Debe ingresar la dosis a suministrar");
		return false;
	}
	
	if($('id_unidadModi').value == 0){
		alert("Debe seleccionar una unidad de medica válida");
		return false;
	}
	
	if($('frecuenciaModi').value < 1 || $('id_frecuenciaModi').value == 0){
		alert("Debe diligenciar una frecuencia válida");
		return false;
	}
	
	if($('id_viaModi').value == 0){
		alert("Debe seleccionar una vía de administración válida");
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarMedicamentoModi';
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
			eliminarMedicamentoMod(id_tabla);
			$('div_lista_medicamento_modi').set('html','');	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Nueva orden médica</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/ordenamiento/crearOrden_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('fecha_ini_ord',date('Y-m-d H:i:s'));
echo form_hidden('id_orden',$orden['id_orden']);
?>
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
<tr><td class="campo" width="30%">Medico tratante:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr>
  <th colspan="2">Orden médica</th></tr>
<tr>
<tr>
<td class="campo" rowspan="2">Dieta:</td>
<td id="div_lista_dietas">
<?php
	foreach($ordenDietas as $d)
	{
		$d['dieta'] = $this->urgencias_model->obtenerDieta($d['id_dieta']);
		echo $this->load->view('urg/urg_ordInfoDieta',$d);
	}
?>
</td>
</tr>
<tr>
<td>
<center>
<select id="id_dieta_" name="id_dieta_">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
foreach($dietas as $d)
{
	echo '<option value="'.$d['id_dieta'].'">'.$d['dieta'].'</option>';
}
?>
</select>
<?
$data = array(	'name' => 'bv',
				'onclick' => "agregarDieta()",
				'value' => 'Agregar',
				'type' =>'button');
echo nbs(),form_input($data);
?>
</center>
</td></tr>
<tr><td class="campo">Posición de la cama:</td>
<td>
Cabecera:&nbsp;<?=form_input(array('name' => 'cama_cabeza',
							'id'=> 'cama_cabeza',
							'maxlength'   => '3',
							'size'=> '3',
							'value'=>$orden['cama_cabeza'],
							'onChange' => "vNum('cama_cabeza','0','90')",
							'class' => "fValidate['integer']"))?>Grados&nbsp;&nbsp;&nbsp;
Pie de cama:&nbsp;<?=form_input(array('name' => 'cama_pie',
							'id'=> 'cama_pie',
							'maxlength'   => '3',
							'size'=> '3',
							'value'=>$orden['cama_pie'],
							'onChange' => "vNum('cama_pie','0','45')",
							'class' => "fValidate['integer']"))?>Grados&nbsp;                         
</td></tr>
<tr><td class="campo">Suministro de Oxigeno:<?=$orden['oxigeno']?></td>
    <td>
<?php
	$res1 = '';
	$res2 = '';
	if($orden['oxigeno'] == 'SI'){
		$res1 = 'checked="checked"';
	}else if($orden['oxigeno'] == 'NO'){
		$res2 = 'checked="checked"';
	}
?>
SI&nbsp;<input name="oxigeno" id="oxigeno" type="radio" value="SI" onchange="tipoOxigeno('SI')" <?=$res1?>/>
NO&nbsp;<input name="oxigeno" id="oxigeno" type="radio" value="NO" onchange="tipoOxigeno('NO')" <?=$res2?>/>
    <div id="div_oxigeno">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Tipo de Oxigeno a suministrar:</td>
    <td><select name="id_oxigeno" id="id_oxigeno" onchange="saturacionOxigeno()">
<option value="0">-Seleccione uno-</option>
<?
foreach($o2 as $d)
{
	if($d['id_oxigeno'] == $orden['id_tipo_oxigeno'])
	{
		echo '<option value="'.$d['id_oxigeno'].'" selected="selected">'.$d['oxigeno'].'</option>';
	}else{
		echo '<option value="'.$d['id_oxigeno'].'">'.$d['oxigeno'].'</option>';	
	}
}
?>
</select></td>
  </tr>
  <tr>
    <td>Cocentración de oxigeno:</td>
    <td id="tipo_oxigeno">
    <select name="id_oxigeno_valor" id="id_oxigeno_valor">
<option value="0">-Seleccione uno-</option>
<?
foreach($id_oxigeno_valor as $d)
{
	if($orden['id_oxigeno_valor'] == $d['id_oxigeno_valor'])
	{
		echo '<option value="'.$d['id_oxigeno_valor'].'" selected="selected">'.$d['tipo_oxigeno'].'</option>';
	}else{
		echo '<option value="'.$d['id_oxigeno_valor'].'">'.$d['tipo_oxigeno'].'</option>';
	}
}
?>
</select>
    
    </td>
  </tr>
</table>

    <br />
</div>
<tr>
    <td class="campo">Suministro de líquidos:</td>
    <td>
<?php
	$res1 = '';
	$res2 = '';
	if($orden['liquidos'] == 'SI'){
		$res1 = 'checked="checked"';
	}else if($orden['liquidos'] == 'NO'){
		$res2 = 'checked="checked"';
	}
?>
SI&nbsp;<input name="liquidos" id="liquidos" type="radio" value="SI" <?=$res1?>/>
NO&nbsp;<input name="liquidos" id="liquidos" type="radio" value="NO" <?=$res2?>/></td></tr>
<tr><th colspan="2" id="mosAgrCui">Cuidados generales y enfermería:</th></tr>
<tr><td colspan="2">
<div id="div_lista_cuidados">
<?php
	foreach($ordenCuid as $d)
	{
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia_cuidado']);
		$d['cuidado'] = $this->urgencias_model->obtenerCuidadoDetalle($d['id_cuidado']);
		echo $this->load->view('urg/urg_ordInfoCuidado',$d);
	}
?>  
</div>
</td></tr>
<tr><td colspan="2">
<?=$this->load->view('urg/urg_ordAgreCuidados',$med)?>
</td></tr>
<tr>
    <td class="campo">Otros cuidados:</td>
    <td><?=form_textarea(array('name' => 'cuidados_generales',
							'id'=> 'cuidados_generales',
							'rows' => '5',
							'cols'=> '45'))?></td></tr>
<tr>
  <th colspan="2" id="mosAgrMed">Medicamentos ordenados anteriormente</th></tr>
<tr>
<tr>
  <td colspan="2">
  <?php
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		$d['id'] = $d['id'];
		$d['bandera'] = $bandera;
		echo $this->load->view('urg/urg_ordInfoMedicamentoCont',$d);
	}
?>  
  </td>
</tr> 
<tr>
  <th colspan="2" id="mosAgrMed">Medicamentos nuevos o modificados</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_medicamento">

  </div>
  </td></tr>
  <tr>
  <td colspan="2">
  <div id="div_lista_medicamento_modi">

  </div>
  </td></tr>
  <tr><td colspan="2" class="linea_azul"></td></tr> 
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
  <tr><td class='campo_centro' colspan='2'>Procedimientos y servicios comunes de Urgencias</td></tr>
   <tr>
  <td class='campo_centro'>Tipo de procedimiento</td><td class='campo_centro'>Procedimiento</td>
  <tr> <td>
  <select name="id_tipo" id="id_tipo" onchange="tipoCups()">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($tipo_cups as $d)
{
	echo '<option value="'.$d['id_tipo'].'">'.$d['nombre_tipo'].'</option>';
}

?>
</select>
  
  </td><td id='div_cupsUrge'>
 
  <select name="id_subcategoriaUrg" id="id_subcategoriaUrg">
  <option value="0" selected="selected">-Seleccione uno-</option>
  </select>
  </td>
  </tr>
  
  <tr>
  <td id='div_cupsLab' colspan="2">
  
  
  
  </td>
  </tr>
    
  
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
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
<?=form_close();?>
</td></tr></table>
