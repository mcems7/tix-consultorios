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
   
   obtenerModulo();
   
   
   
}); 

function obtenerModulo()
{
	 var servicio =$('id_modulo').value;
	 if (servicio==0){
		 hematologia();
		 microbiologia();
		 quimica();
		 }
	
	 if (servicio==1){
		 hematologia();
		 }
	  if (servicio==2){
		  quimica();
		 }
   if (servicio==3){
		  microbiologia();
		 }
		 
      if (servicio==4){
		  uroanalisis();
		 }
	   if (servicio==5){
		  inmunologia();
		 }
		 
		 if (servicio==6){
		  coagulacion();
		 }
   
	   if (servicio==7){
		  serologia();
		 }
	
}


////////////////////////////////////////////////////////////////////////////////

function hematologia()
{
  
  var var_url = '<?=site_url()?>/lab/laboratorio/OrdenesHematologia'
  var ajax1 = new Request(
  {
    url: var_url,
    method: 'post',
    data:  $('formulario').toQueryString(),
    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_hematologia').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

function tomarOrden()
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

function RegistrarOrden()
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
<h1 class="tituloppal">Laboratorio Clinico</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>

<table width="100%" class="tabla_form">

<tr><td style="padding:0px">
<?php
$id = $this->session->userdata('id_modulo');
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
$res5 = '';
$res6 = '';
$res7 = '';
$res8 = '';
if($id == 1){
	$res1 = 'selected="selected"';
}else if($id == 2){
	$res2 = 'selected="selected"';
}else if($id == 3){
	$res3 = 'selected="selected"';
}else if($id == 4){
	$res4 = 'selected="selected"';
}else if($id == 5){
	$res5 = 'selected="selected"';
}else if($id == 6){
	$res6 = 'selected="selected"';
}else if($id == 7){
	$res7 = 'selected="selected"';
}else{
	$res8 = 'selected="selected"';
}
?>


<select name="id_modulo" id="id_modulo" onchange="obtenerModulo()">
  <option value="0" <?=$res5?>>-Todas-</option>
  <option value="1" <?=$res1?>>Hematologia</option>
  <option value="2" <?=$res2?>>otro lab</option>
  <option value="3" <?=$res3?>>Otro lab</option>

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
Hematologia:&nbsp;</th></tr>
<tr><td style="padding:0px">
<div id="div_hematologia">
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
Quimica:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_quimica">
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
Microbiologia:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_microbiologia">
</div>
</td></tr>

</table>

<?=form_close();?>

<br />

<?php
$attributes = array('id'       => 'formulario4',
                  'name'     => 'formulario4',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Uroanalisis:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_uroanalisis">
</div>
</td></tr>

</table>

<?=form_close();?>

<br />

<?php
$attributes = array('id'       => 'formulario5',
                  'name'     => 'formulario5',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Coagulacion:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_coagulacion">
</div>
</td></tr>

</table>

<?=form_close();?>

<br />

<?php
$attributes = array('id'       => 'formulario6',
                  'name'     => 'formulario6',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Inmunologia:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_inmunologia">
</div>
</td></tr>

</table>

<?=form_close();?>

<br />

<?php
$attributes = array('id'       => 'formulario7',
                  'name'     => 'formulario7',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Serologia:&nbsp;

</th></tr>
<tr><td style="padding:0px">
<div id="div_serologia">
</div>
</td></tr>

</table>

<?=form_close();?>


