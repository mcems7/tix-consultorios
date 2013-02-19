<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerSala();					 
});
////////////////////////////////////////////////////////////////////////////////

function consultaPaciente(id_atencion)
{
	var campo = 'id_estado'+id_atencion;
	var id_estado = $(campo).value;
       	
	if(id_estado == 3){
			alert('El paciente se encuentra actualmente en consulta!!');
			
			if(confirm('¿Desea iniciar la atención del paciente?'))
	{
		document.location = '<?=site_url()?>/urg/atencion_inicial/consultaInicial/'+id_atencion;
		return true;
	}
	else
	{
		return false;
	}	
	}
	
        if(id_estado == 4){
	        
                document.location = '<?=site_url()?>/urg/atencion_inicial/consultaInicial/'+id_atencion;
		return true;		
			                                
                          }
	if(confirm('¿Desea iniciar la atención del paciente?'))
	{
		document.location = '<?=site_url()?>/urg/atencion_inicial/consultaInicial/'+id_atencion;
		return true;
	}
	else
	{
		return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function obtenerSala()
{
	var var_url = '<?=site_url()?>/urg/salas/listadoPacientesSala';
	var ajax1 = new Request(
	{
		url: var_url,
		method:'post',
		evalScripts: true,
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_sala').set('html', html);
		$('div_precarga').style.display = "none";},
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
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
<h1 class="tituloppal">Servicio de urgencias - Salas de espera</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr><th style="text-align:right">
Salas atenci&oacute;n inicial de urgencias:<?=nbs()?>
<?php
$id = $this->session->userdata('id_servicio');
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
$res5 = '';
if($id == 12){
	$res1 = 'selected="selected"';
}else if($id == 13){
	$res2 = 'selected="selected"';
}else if($id == 14){
	$res3 = 'selected="selected"';
}else if($id == 15){
	$res4 = 'selected="selected"';
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
</select>
</th></tr>
<tr><td style="padding:0px">
<div id="div_detalle_sala">
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
