<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerConsultorio();					 
});
////////////////////////////////////////////////////////////////////////////////
function no_responde(id_atencion)
{
	if(confirm('¿El paciente no responde al llamado?\n¿Desea cancelar la cita del paciente?'))
	{
		document.location = '<?=site_url()?>/coam/coam_gestion_atencion/no_responde/'+id_atencion;
		return true;
	}else{
		return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function consultaPaciente(id_atencion)
{
	var campo = 'id_estado'+id_atencion;
	var id_estado = $(campo).value;
	
	if(id_estado == 2){
			alert('El paciente se encuentra actualmente en consulta!!');
			
			if(confirm('¿Desea iniciar la atención del paciente?'))
		{
		document.location = '<?=site_url()?>/coam/coam_gestion_atencion/consulta_ambulatoria/'+id_atencion;
		return true;
		}
		else
		{
			return false;
		}	
	}
	
	if(id_estado == 1){
	if(confirm('¿Desea iniciar la atención del paciente?'))
	{
		document.location = '<?=site_url()?>/coam/coam_gestion_atencion/consulta_ambulatoria/'+id_atencion;
		return true;
	}
	else
	{
		return false;
	}
	}
	
	if(id_estado == 3){
		document.location = '<?=site_url()?>/coam/coam_gestion_atencion/main/'+id_atencion;
		return true;	
	}
}
////////////////////////////////////////////////////////////////////////////////
function obtenerConsultorio()
{
	var consultorio = $('id_consultorio').value;
	if(consultorio == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/coam/coam_gestion_atencion/listadoPacientesConsultorio';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_consultorio').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
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
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Listado pacientes consultorio</h2>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">
Consultorio:&nbsp;
<?php
$id = $this->session->userdata('id_consultorioCoam');
?>
<select name="id_consultorio" id="id_consultorio" onchange="obtenerConsultorio()">
    <option value="0">-Seleccione uno-</option>
<?php
foreach($consultorios as $d)
{
	if($id == $d['id_consultorio']){
	echo '<option value="'.$d['id_consultorio'].'" selected="selected">'.$d['consultorio'].'</option>';	
	}else{
	echo '<option value="'.$d['id_consultorio'].'">'.$d['consultorio'].'</option>';	
	}
}
?>      
    </select>
</th></tr>
<tr><td style="padding:0px">
<div id="div_detalle_consultorio">
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