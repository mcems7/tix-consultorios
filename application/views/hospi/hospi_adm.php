<script language="javascript">
// JavaScript Document
remitido = null;
////////////////////////////////////////////////////////////////////////////////
function obtenerContratosEntidad()
{
	var var_url = '<?=site_url()?>/hospi/hospi_admision/obtenerContratosEntidad';
	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('div_contrato').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function paciente_remitido(val)
{
	if(val == 'NO')
		remitido.slideOut();
	if(val == 'SI')
		remitido.slideIn();
}
////////////////////////////////////////////////////////////////////////////////
function obtenerDepartamento()
{
	var var_url = '<?=site_url()?>/core/administrar_ter/obtenerDepartamento';
	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('div_lista_departamentos').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function obtenerMunicipio()
{
	var var_url = '<?=site_url()?>/core/administrar_ter/obtenerMunicipio';
	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('div_lista_municipios').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function noAplicaMunicipio()
{
	var var_url = '<?=site_url()?>/core/administrar_ter/noAplicaMunicipio';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('div_lista_municipios').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function verificar_entidad()
{
	var origen = $('id_origen').value;
	if(origen == 0){
		return false;	
	}
	
	var var_url = '<?=site_url()?>/hospi/hospi_admision/verificarEntidad';	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('responsable_pago').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	var tipo_documento = $('id_tipo_documento').value;
	var pais = $('pais').value;
	var departamento = $('departamento').value;
	var municipio = $('municipio').value;
	
	if(tipo_documento == 0){
		alert("Debe seleccionar un tipo de documento de la lista!!");
		return false;}
	
	if(pais == 0){
		alert("Debe seleccionar un País de la lista!!");
		return false;}
	
	if(departamento == 0){
		alert("Debe seleccionar un departamento de la lista!!");
		return false;}
		
	if(municipio == 0){
		alert("Debe seleccionar un municipio de la lista!!");
		return false;}
	
	for(i=0; i <document.formulario.zona.length; i++){
    if(document.formulario.zona[i].checked){
      var val = document.formulario.zona[i].value;}
    }
	if(!(val == 'Urbana' || val == 'Rural')){
		alert("Debe seleccionar una zona, Urbana o Rural!!");
		return false;
	}
	
	for(i=0; i <document.formulario.genero.length; i++){
    if(document.formulario.genero[i].checked){
      var val = document.formulario.genero[i].value;}
    }
	if(!(val == 'Femenino' || val == 'Masculino' || val == 'Indefinido')){
		alert("Debe seleccionar el genero del paciente!!");
		return false;
	}
	
	var estado_civil = $('estado_civil').value;
	if(estado_civil == 0){
		alert("Debe seleccionar un estado civil!!");
		return false;}
		
	if($('id_cobertura').value == 0){
		alert("Debe seleccionar un tipo de usuario!!");
		return false;}
		
	if($('id_entidad').value == 0){
		alert("Debe seleccionar una Entidad administradora de planes de beneficio!!");
		return false;}
		
	if($('tipo_afiliado').value == 0){
		alert("Debe seleccionar el tipo de afiliado!!");
		return false;}
	
	for(i=0; i <document.formulario.desplazado.length; i++){
    if(document.formulario.desplazado[i].checked){
      var val = document.formulario.desplazado[i].value;}
    }
	if(!(val == 'SI' || val == 'NO')){
		alert("Debe indicar si el paciente es desplazado o no!!");
	}
	
var origen = $('id_origen').value;
	if(origen == 0){
		alert("Debe seleccionar el origen de la atención!!");
		return false;	
	}
	
	var valor = $('id_entidad_pago').value;
	if(valor == 0){
		alert("Debe seleccionar la entidad responsable de pago!!");
		return false;	
	}
	
	var id_ser = $('id_contrato').value;
	if(id_ser == 0){
		alert("Debe seleccionar un contrato!!");
		return false;	
	}
	
	var id_ser = $('id_servicio').value;
	if(id_ser == 0){
		alert("Debe seleccionar un servicio hospitalario!!");
		return false;	
	}
	
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
 var exValidatorA = new fValidator("formulario");
  remitido = new Fx.Slide('div_remitido');
 remitido.hide();	 
});
////////////////////////////////////////////////////////////////////////////////
</script>