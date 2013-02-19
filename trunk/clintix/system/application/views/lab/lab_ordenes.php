<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
  obtenerOrden();           
});


////////////////////////////////////////////////////////////////////////////////

function obtenerOrden()
{
  var sala = $('tipoOrd').value;
  if(sala == 0){
    return false;
  }
  
  var var_url = '<?=site_url()?>/lab/laboratorio/listadoOrdenesLab/'+sala;
  var ajax1 = new Request(
  {
    url: var_url,
    method: 'post',
    data:  $('formulario').toQueryString(),
    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_detalle_sala').set('html', html);
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
$id = $this->session->userdata('id_ordenesLab');
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
$res5 = '';
if($id == 1){
	$res1 = 'selected="selected"';
	}
else if($id == 2) {
	$res2 = 'selected="selected"';
	}
else{
	$res5 = '"';
}

$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
                  'name'     => 'formulario',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<h1 class="tituloppal">Ordenes Laboratorio Clinico</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Servicios:&nbsp;
<select name="" id="tipoOrd" onchange="obtenerOrden()">
  <option value="0"<?=$res1?>>-Seleccione uno-</option>
  <option value="1"<?=$res5?>>Todas</option>
  <option value="2"<?=$res4?>>Recepcionar</option>
  <option value="3"<?=$res3?>>Tomar</option>

</select>
</th></tr>
<tr><td style="padding:0px">
<div id="div_detalle_sala">
</div>
</td></tr>
<tr><td align="center">
<?
$data = array(  'name' => 'bv',
        'onclick' => 'regresar()',
        'value' => 'Volver',
        'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?=form_close();?>