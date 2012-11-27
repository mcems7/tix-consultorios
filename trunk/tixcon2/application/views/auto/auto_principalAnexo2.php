<script type="text/javascript">
function con() {
    if(confirm('¿Esta seguro que desea enviar el reporte del anexo 2?'))
	{
		return true;
	  
 }else{
 
 return false;
 }
}
</script>
<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerListado();			 
});
////////////////////////////////////////////////////////////////////////////////
function obtenerListado()
{
	var var_url = '<?=site_url()?>/auto/anexo2/listadoAnexos2';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_listado').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);
?>
<h1 class="tituloppal">Central de autorizaciones - Gesti&oacute;n anexo t&eacute;cnico 2</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">Enviado:
<?php $js = 'onChange="obtenerListado()"';?>
<?=nbs().'SI'.nbs().form_radio('enviado', 'SI',FALSE,$js)?>
<?=nbs().'NO'.nbs().form_radio('enviado', 'NO',TRUE,$js)?>
<?=nbs().'Todos'.nbs().form_radio('enviado', 'Todos',FALSE,$js)?>
</th></tr>
<tr><td style="padding:0px" id="div_listado">

</td></tr>
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?=form_close();?>
