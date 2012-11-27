<script type="text/javascript">
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

function simple()
{
	var var_url = '<?=site_url()?>/lab/lab_adm_clinicos/cupsSimple';
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

</script>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="35%">Cups:</td><td width="65%">
<input size="60" type="text" id="nombre" name="nombre" value="" 
onkeyup="ajax_showOptions(this,'lab/lab_adm_clinicos/cupsLab',event)" AUTOCOMPLETE="off">

<input type="hidden" id="nombre_hidden" name="cups_ID">
<input type="hidden" id="flagCups" name="flagCups" value="simple">
</td></tr>

</table>