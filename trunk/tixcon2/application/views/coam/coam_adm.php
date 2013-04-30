<script language="javascript">
// JavaScript Document
remitido = null;
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
		
	if($('id_entidad').value == 0){
		alert("Debe seleccionar una Entidad administradora de planes de beneficio!!");
		return false;}
		
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
});
////////////////////////////////////////////////////////////////////////////////
</script>