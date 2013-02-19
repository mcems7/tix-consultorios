<script language="javascript">
function agregar_dX()
{
	if(!validarDx())
	{
		return false;
	}
	var contDx = $('contDx').value;
	
	$('orden_dx').value = parseInt(contDx);
	
	$('contDx').value = parseInt(contDx)+1;
	
	var var_url = '<?=site_url()?>/util/diagnosticos/agregar_dx';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_dx').get('html');
		$('div_lista_dx').set('html',html2, html);
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
function validarDx()
{
	if($('dx_hidden').value < 1){
		alert("Debe realizar la búsqueda de un diagnostico");
		return false;
	}
	
	var a = $('tipo_dx_0').checked;
	var b = $('tipo_dx_1').checked;
	var c = $('tipo_dx_2').checked;
	
	if(a != true && b != true && c != true){
		alert("Debe seleccionar el tipo de diagnóstico!!");
		return false;	
	}

	return true;
}
////////////////////////////////////////////////////////////////////////////////
function borrarForm()
{	
	$('dx_hidden').value = '';
	$('dx').value = '';
	
	for(i=0; i < document.formulario.tipo_dx.length; i++)
	{	
		if(document.formulario.tipo_dx[i].checked == true)
		{
			document.formulario.tipo_dx[i].checked = false;
		}
	}
	
	simple();
}
////////////////////////////////////////////////////////////////////////////////
function eliminarDx(id_tabla)
{	
	if(confirm('¿Desea eliminar el diagnostico seleccionado?')){
		var contDx = $('contDx').value;
		$('contDx').value = parseInt(contDx)-1;
		$(id_tabla).dispose();	
	}
}
////////////////////////////////////////////////////////////////////////////////
function avanzado()
{
	var var_url = '<?=site_url()?>/util/diagnosticos/dxAvanzados';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_dx').set('html', html);
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
	var var_url = '<?=site_url()?>/util/diagnosticos/dxSimple';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_dx').set('html', html);
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
