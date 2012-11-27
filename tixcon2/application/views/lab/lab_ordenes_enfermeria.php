<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////



function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////


window.addEvent('domready', function() {
   //aquí las acciones que quieras realizar cuando el DOM esté listo
   
   obtenerSala();
   
   
   
}); 

function obtenerSala()
{
	 var servicio =$('id_servicio').value;
	 obtenerOrden(servicio);
   tomarOrden(servicio);
   RegistrarOrden(servicio);
	
	
}


////////////////////////////////////////////////////////////////////////////////

function obtenerOrden(servicio)
{
  
  var var_url = '<?=site_url()?>/lab/lab_lista_enfermeria/listadoOrdenesLabRechazada/'+servicio
  var ajax1 = new Request(
  {
    url: var_url,
    method: 'post',
    data:  $('formulario').toQueryString(),
    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_muestras_devueltas').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

function tomarOrden(servicio)
{
  
  
  var var_url = '<?=site_url()?>/lab/lab_lista_enfermeria/listadoOrdenesLabEnfermeria/'+servicio
  var ajax1 = new Request(
  {
    url: var_url,
    method: 'post',
    data:  $('formulario2').toQueryString(),
    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_muestras_tomar').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}

////////////////////////////////////////////////////////////////////////////////

function RegistrarOrden(servicio)
{
  
  
  var var_url = '<?=site_url()?>/lab/lab_lista_enfermeria/listadoOrdenesRegUrg/'+servicio
  var ajax1 = new Request(
  {
    url: var_url,
    method: 'post',
    data:  $('formulario3').toQueryString(),
    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_muestras_registrar').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}


////////////////////////////////////////////////////////////////////////////////
function confirmarordrem() {
    if(confirm('¿Esta seguro que desea remitir la orden a laboratorio?'))
	{
		return true;
	  
 }else{
 
 return false;
 }
}
///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function confirmarordenv() {
    if(confirm('¿Esta seguro que desea enviar la orden para recepcion en laboratorio?'))
	{
		return true;
	  
 }else{
 
 return false;
 }
}
///////////////////////////////////////////////////////////////////////////////
function confirmbaja() {
    if(confirm('¿La orden pasara a la lista Ordenes por Tomar?'))
	{
		return true;
	  
 }else{
 
 return false;
 }	
}
	
	

</script>
<?php $fecha_actual = date('Y-m-d H:i:s'); ?>
<h1 class="tituloppal">Ordenes Laboratorio Clinico</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>

<table width="100%" class="tabla_form">

<tr><td style="padding:0px">
<?php
$id = $this->session->userdata('id_servicio');
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
$res5 = '';
$res6 = '';
$res7 = '';
$res8 = '';
if($id == 12){
	$res1 = 'selected="selected"';
}else if($id == 13){
	$res2 = 'selected="selected"';
}else if($id == 14){
	$res3 = 'selected="selected"';
}else if($id == 15){
	$res4 = 'selected="selected"';
}else if($id == 16){
	$res6 = 'selected="selected"';
}else if($id == 17){
	$res7 = 'selected="selected"';
}else if($id == 18){
	$res8 = 'selected="selected"';
}else{
	$res5 = 'selected="selected"';
}
?>


<select name="id_servicio" id="id_servicio" onchange="obtenerSala()">
  <option value="0" <?=$res5?>>-Seleccione una-</option>
  <option value="12" <?=$res1?>>Urgencias Adultos</option>
  <option value="13" <?=$res2?>>Urgencias Pediátricas</option>
  <option value="14" <?=$res3?>>Urgencias Ginecobstétricas</option>
  <option value="15" <?=$res4?>>Urgencias Psiquiátricas</option>
  <option value="16" <?=$res6?>>Urgencias Observación Adultos</option>
  <option value="17" <?=$res7?>>Urgencias Observación Pedriáticas</option>
  <option value="18" <?=$res8?>>Urgencias Observación Psiquiátricas</option>
</select>

</td></tr>

</table>
<br />

<?php


$attributes = array('id'       => 'formulario',
                  'name'     => 'formulario',
          'method'   => 'post');
echo form_open('',$attributes);

?>


<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Muestras Devueltas:&nbsp;</th></tr>
<tr><td style="padding:0px">
<div id="div_muestras_devueltas">
</div>
</td></tr>

</table>
<?=form_close();?>
<br />

<?php
$attributes = array('id'       => 'formulario2',
                  'name'     => 'formulario2',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Muestras por Tomar:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_muestras_tomar">
</div>
</td></tr>

</table>

<?=form_close();?>


<br />

<?php
$attributes = array('id'       => 'formulario3',
                  'name'     => 'formulario3',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Muestras por Registrar:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_muestras_registrar">
</div>
</td></tr>

</table>

<?=form_close();?>


