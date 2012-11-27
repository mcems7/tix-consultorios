<script language="javascript">
////////////////////////////////////////////////////////////////////////////////
function agregarDieta()
{	
	var id = $('id_dieta_').value;
	if(id == 0){
		alert('Debe seleccionar una dieta de la lista!!');
		return false;	
	}
	var var_url = '<?=site_url()?>/util/ordenes/agregarDieta';
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
		onFailure: function(){alert('Error ejecutando ajax!');}
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
	var var_url = '<?=site_url()?>/util/ordenes/tipoOxigeno';
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
	
	var var_url = '<?=site_url()?>/util/ordenes/agregarMedicamento';
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
function agregarCuidado()
{
	if(!validarCuidado())
	{
		return false;
	}
	
	var var_url = '<?=site_url()?>/util/ordenes/agregarCuidado';
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
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function eliminarMedicamento(id_tabla)
{	
	if(confirm('¿Desea eliminar el medicamento seleccionado?'))
		$(id_tabla).dispose();	
}
////////////////////////////////////////////////////////////////////////////////
function eliminarDieta(id_tabla)
{	
	if(confirm('¿Desea eliminar la dieta seleccionada?'))
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
<?php
if(isset($orden)){
?>
function modificarMed(id,accion,marca){
	
	$('div_lista_medicamento_modi').set('html','');
	
	var objeto = "opcionMed"+id;
	var elementos = document.getElementsByName(objeto);
	
	
	var id_tabla = "tmc"+marca;
	if(accion == 'Modificar')
	{
		
		if(confirm("¿Está seguro de querer modificar la dosis del medicamento?"))
		{
			
						
	var var_url = '<?=site_url()?>/util/ordenes/consultaMedicaModi/'+id+'/<?=$orden['id_orden']?>/'+marca;
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
		onFailure: function(){alert('Error ejecutando ajax!');}
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
<?php
}
?>
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
	
	var var_url = '<?=site_url()?>/util/ordenes/agregarMedicamentoModi';
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
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

</script>
