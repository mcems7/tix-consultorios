<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Consultar orden m&eacute;dica</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo">Fecha y hora de la orden:</td><td><?=$orden['fecha_creacion']?></td></tr>
<tr><td class="campo" width="30%">Medico tratante:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr>
  <th colspan="2">Medicamentos</th></tr>
<tr>
<tr>
  <td colspan="2">
<?php
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		$d['estado'] = '';
		echo $this->load->view('urg/urg_ordInfoConMedicamento',$d);
	}
?>  
</td></tr>
<tr><td colspan="2" align="center">
<?php
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/coam/ordenMed/'.$orden['id_orden'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
<tr><th colspan="2">Procedimientos y ayudas diagnosticas</th></tr>
<tr>
<td colspan="2">
<div id="div_lista_procedimientos">
<?php
foreach($ordenCups as $d)
{
	$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
	echo $this->load->view('urg/urg_ordInfoConProcedimiento',$d);
}
?>
</div>
</td></tr>
<tr><td colspan="2" align="center">
<?php
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/coam/ordenCups/'.$orden['id_orden'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</center>
</div>
<br />
</td></tr></table>