<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function resetDiv(atc)
{	
	var obj = "div_"+atc;
	$(obj).set('html','');
}
////////////////////////////////////////////////////////////////////////////////
function consultaMedi(atc)
{
	var id = <?=$atencion['id_atencion']?>;
	var obj = "div_"+atc;
	var var_url = '<?=site_url()?>/far/main/historiaMedicamento/'+id+'/'+atc;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$(obj).set('html', html);
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

<h1 class="tituloppal">Servicio Farmaceutico</h1>
<h2 class="subtitulo">Orden De Médicamentos</h2>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
	echo form_open('/far/main/consultarOrden_',$attributes);
	echo form_hidden('id_orden',$orden['id_orden']);
?>
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
<tr><td class="campo">Peso:</td><td><?php $peso=$this->urgencias_model->obtenerConsulta($atencion['id_atencion']); echo $peso['peso']; ?></td>
<td class="campo">Ingreso Dinamica:</td><td><?=$atencion['ingreso']?></td></tr>
<tr></tr>
  <tr>
  <td class="campo">Servicio:</td><td><?=$atencion['nombre_servicio']?></td>
  <td class="campo">Cama:</td><td>
  <?=$cama['numero_cama']
  ?>
  </td></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo">Fecha y hora de la orden:</td><td><?=date('Y-m-d H:i:s')?></td></tr>
<tr><td class="campo" width="30%">Medico tratante:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr><td class="campo">Diagnostico(s):</td><td><?php $diagnostico=$this->farmacia_model->obtenerDxFarmacia($atencion['id_atencion']); 
foreach($diagnostico as $d)
  {
    echo $d['diagnostico']; echo "";?> <br> <?php } ?></td></tr>
<tr><td class="campo">Asegurador:</td><td><?php $entidad=$this->farmacia_model->obtenerNombreEntidad($atencion['id_paciente']); echo $entidad['razon_social']; ?></td></tr>
<tr>
  <th colspan="2">Medicamentos</th></tr>
<tr>
  <td colspan="2">
<?php
  foreach($ordenMedi as $d)
  {
    $d['via'] = $this->farmacia_model->obtenerValorVarMedi($d['id_via']);
    $d['uni_frecuencia'] = $this->farmacia_model->obtenerValorVarMedi($d['id_frecuencia']);
    $d['unidad'] = $this->farmacia_model->obtenerValorVarMedi($d['id_unidad']);
    $d['medicamento'] = $this->farmacia_model->obtenerNomMedicamento($d['atc']);
    $d['principio_activo'] = $this->farmacia_model->obtenerPrincipioActivo($d['atc']);
	if($d['estado'] == 'Suspendido'){
		echo $this->load->view('far/far_ordInfoConMedicamentoSus',$d);
	}else{
		echo $this->load->view('far/far_ordInfoConMedicamento',$d);
	}
	
  }
?>  
  </td></tr> 
<tr>
  <th colspan="2">Insumos y dispositivos</th></tr>
<tr>
  <td colspan="2">
<?php
  foreach($ordenInsu as $d)
  {
    echo $this->load->view('far/far_ordInfoConInsumos',$d);
  }
?>  
  </td></tr>                                
</table>
<center>
  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
</td></tr></table>
<?=form_close();?>