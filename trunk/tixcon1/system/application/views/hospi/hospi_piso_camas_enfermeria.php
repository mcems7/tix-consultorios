<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerPiso();					 
});
////////////////////////////////////////////////////////////////////////////////
function obtenerPiso()
{
	var piso = $('id_servicio').value;
	if(piso == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/hospi/hospi_enfermeria/listadoPacientesPiso';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_piso').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function ingresoServicio(id_aten,id_ser)
{
	if(confirm('¿Desea realizar el ingreso del paciente al servicio?'))
	{
		var div = 'cama'+id_aten;
		var var_url = '<?=site_url()?>/hospi/hospi_gestion_atencion/ingresoServicio/'+id_aten+'/'+id_ser;
		var ajax1 = new Request(
		{
			url: var_url,
			onSuccess: function(html){$(div).set('html', html);},
			evalScripts: true,
			onFailure: function(){alert('Error ejecutando ajax!');}
		});
		ajax1.send();	
	}
	else
	{
		return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function asignarCama(id_atencion)
{
	var cama = $('id_cama').value;
	if(cama == 0){
		alert('Seleccione la cama a ser asignada!!');
		return false;	
	}
	
	var div = 'cama'+id_atencion;
	var var_url = '<?=site_url()?>/hospi/hospi_gestion_atencion/ingresoServicioCama/'+id_atencion+'/'+cama;
	var ajax1 = new Request(
	{
		url: var_url,
		onSuccess: function(html){$(div).set('html', html);},
		onComplete: function(){obtenerPiso();},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function activarCama(id_cama)
{
	var sala = $('id_servicio').value;
	if(sala == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/hospi/hospi_gestion_atencion/activarCama/'+id_cama;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_piso').set('html', html);
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
<h1 class="tituloppal">Unidad de hospitalización enfermeria</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">
Servicio:&nbsp;
<?php
$id = $this->session->userdata('id_servicioHospi');
?>
<select name="id_servicio" id="id_servicio" onchange="obtenerPiso()">
    <option value="0">-Seleccione uno-</option>
<?php
foreach($servicios as $d)
{
	if($id == $d['id_servicio']){
	echo '<option value="'.$d['id_servicio'].'" selected="selected">'.$d['nombre_servicio'].'</option>';	
	}else{
	echo '<option value="'.$d['id_servicio'].'">'.$d['nombre_servicio'].'</option>';	
	}
}
?>      
    </select>
    &nbsp;Estado de las camas:&nbsp;
<select name="estado" id="estado" onchange="obtenerPiso()">
  <option value="0">Todas</option>
 <?php
 	foreach($estados as $d)
	{
		echo '<option value="'.$d['id_estado'].'">'.$d['estado'].'</option>';	
	}
 ?>
</select>
</th></tr>
<tr><td style="padding:0px">
<div id="div_detalle_piso">
</div>
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
