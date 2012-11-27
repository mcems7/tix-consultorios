<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de Urgencias - Historia cl&iacute;nica del paciente por atenci&oacute;n</h4>
<h5>Datos del paciente</h5>
<table id="interna">
  <tr>
    <td class="negrita">Apellidos:</td>
    <td class="centrado"><?=$tercero['primer_apellido'].' '.$tercero['segundo_apellido']?></td>
    <td class="negrita">Nombres:</td>
    <td class="centrado"><?=$tercero['primer_nombre'].' '.$tercero['segundo_nombre']?></td>
  </tr>
  <tr>
    <td class="negrita">Documento de identidad:</td>
    <td class="centrado"><?=$tercero['tipo_documento'].' '.$tercero['numero_documento']?></td>
    <td class="negrita">Fecha de nacimiento:</td>
    <td class="centrado"><?=$tercero['fecha_nacimiento']?></td>
  </tr>
  <tr>
    <td class="negrita">Edad:</td>
    <td class="centrado"><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
    <td class="negrita">G&eacute;nero:</td>
    <td class="centrado"><?=$paciente['genero']?></td>
  </tr>
  <tr>
    <td class="negrita">Entidad:</td>
    <td class="centrado">
    <?php 
		if(isset($entidad['razon_social']))
			echo $entidad['razon_social'];
	?>
    </td>
    <td class="negrita">Pa&iacute;s:</td>
    <td class="centrado"><?=$tercero['PAI_NOMBRE']?></td>
  </tr>
  <tr>
    <td class="negrita">Departamento / Municipio:</td> 
    <td class="centrado"><?=$tercero['depa'].' / '.$tercero['nombre']?></td>
    <td class="negrita">Barrio / Vereda:</td>
    <td class="centrado"><?=$tercero['vereda']?></td>
  </tr>
  <tr>
    <td class="negrita">Zona:</td>
    <td class="centrado"><?=$tercero['zona']?></td>
    <td class="negrita">Direcci&oacute;n:</td>
    <td class="centrado"><?=$tercero['direccion']?></td>
  </tr>
  <tr>
    <td class="negrita">Tel&eacute;fono:</td>
    <td class="centrado"><?=$tercero['telefono']?></td>
    <td class="negrita">Celular:</td>
    <td class="centrado"><?=$tercero['celular']?></td>
  </tr>
  <tr>
    <td class="negrita">Fax:</td>
    <td class="centrado"><?=$tercero['fax']?></td>
    <td class="negrita">Correo electr&oacute;nico:</td>
    <td class="centrado"><?=$tercero['email']?></td>
  </tr>
  <tr>
    <td class="negrita">Observaciones (tercero):</td>
    <td class="centrado"><?=$tercero['observaciones']?></td>
    <td class="negrita">Tipo usuario:</td>
    <td class="centrado">
    <?
		foreach($tipo_usuario as $d)
		{
			if($paciente['id_cobertura'] == $d['id_cobertura'])
			{
				echo $d['cobertura'];
			}
		}
	?>
    </td>
  </tr>
  <tr>
    <td class="negrita">Tipo de afiliado:</td>
    <td class="centrado"><?=$paciente['tipo_afiliado']?></td>
    <td class="negrita">Nivel o categoria:</td>
    <td class="centrado"><?=$paciente['nivel_categoria']?></td>
  </tr>
  <tr>
    <td class="negrita">Desplazado:</td>
    <td class="centrado"><?=$paciente['desplazado']?></td>
    <td class="negrita">Observaciones (paciente):</td>
    <td class="centrado"><?=$paciente['observaciones']?></td>
  </tr>
</table>
<h5>Datos de la atenci&oacute;n</h5>
<table id="interna">
  <tr>
    <td class="negrita">Fecha y hora de ingreso:</td>
    <td class="centrado"><?=$atencion['fecha_ingreso']?></td>
    <td class="negrita">Servicio de ingreso:</td>
    <td class="centrado"><?=$atencion['nombre_servicio']?></td>
  </tr>
  <tr>
    <td class="negrita">Fecha y hora de egreso:</td>
    <td class="centrado"><?=$atencion['fecha_egreso']?></td>
    <td class="negrita">Servicio de egreso:</td>
    <td class="centrado">
    <?php
		$servicio = $this->urgencias_model->obtenerInfoServicio($atencion['id_servicio']);
		echo $servicio['nombre_servicio'];
	?>
    </td>
  </tr>
  <tr>
    <td class="negrita">Paciente remitido:</td>
  <?php
	if($atencion['remitido'] == 'SI')
	{
		$ent_remi = $this->urgencias_model->obtenerEntidadRemision($atencion['codigo_entidad']);	
  ?>
		<td class="centrado"><?=$atencion['remitido']?></td>
    <td class="negrita">Entidad que remite:</td>
    <td class="centrado"><?=$ent_remi['nombre']?></td>
  <?php
	}
	else
	{
  ?>
  	<td class="centrado" colspan="3"><?=$atencion['remitido']?></td>
  <?php	
	}
  ?>  
  </tr>
  <tr>
  	<td class="negrita">Estado de salida:</td>
    <td class="centrado">
    
    <?php
		
		//print_r($epicrisis);
		//die;
		
		echo $epicrisis['estado_salida'];
		
		if($epicrisis['estado_salida'] == 'Muerto')
			echo '&nbsp;' , $epicrisis['tiempo_muerto'];
	?>
    </td>
    <td class="negrita">Incapacidad funcional, Cu&aacute;l?:</td>
    <td class="centrado"><?=$epicrisis['incapacidad_funcional'];?></td>
  </tr>
</table>
<h5>Datos de los diagn&oacute;sticos</h5>
<table id="interna">
  <tr>
    <td class="negrita centrado">De ingreso:</td>
    <td class="negrita centrado">De egreso:</td>
  </tr>
  <tr>
    <td>
   	<?php
		if(count($dx) > 0)
		{
		?>
    	<ol>
    <?php
			foreach($dx as $d)
			{
		?>
    		<li><b><?=$d['id_diag']?></b> <?=$d['diagnostico']?></li>
    <?php
			}
		?>
    	</ol>
    <?php
		}
		?>
    </td>
    <td>
		<?php
		if(count($dx_evo) > 0)
		{
		?>
    	<ol>
    <?php
			foreach($dx_evo as $d)
			{
		?>
    		<li><b><?=$d['id_diag']?></b> <?=$d['diagnostico']?></li>
    <?php
			}
		?>
    	</ol>
    <?php
		}
		?>
    </td>
  </tr>
</table>

<!--------------triage------------------------------>

<h4>Triage del paciente</h4>
<table id="interna">
<tr>
  <td class="negrita">Motivo de la consulta:</td>
  <td colspan="2" class="centrado"><?=$triage['motivo_consulta']?></td>
  <td class="negrita">Antecedentes:</td>
  <td class="centrado"><?=$triage['antecedentes']?></td>
</tr>
<tr>
  <td colspan="5"  class="negrita centrado">Signos vitales</td>
</tr>
<tr>
  <td class="negrita centrado">Frecuencia cardiaca:</td>
  <td class="negrita centrado">Frecuencia respiratoria:</td>
  <td class="negrita centrado">Tensión arterial:</td>
  <td class="negrita centrado">Temperatura:</td>
  <td class="negrita centrado">Pulsioximetría (SPO2):</td>
</tr>
<tr>
  <td class="centrado"><?=$triage['frecuencia_cardiaca']?>&nbsp;X min</td>
  <td class="centrado"><?=$triage['frecuencia_respiratoria']?>&nbsp;X min</td>
  <td class="centrado"><?=$triage['ten_arterial_s'].' / '.$triage['ten_arterial_d']?></td>
  <td class="centrado"><?=$triage['temperatura']?> &deg;C</td>
  <td class="centrado"><?=$triage['spo2']?> %</td>
</tr>
<tr>
  <td rowspan="2" class="negrita centrado">Escala Glasgow:</td>
  <td class="negrita centrado">Respuesta ocular:</td>
  <td class="negrita centrado">Respuesta verbal:</td>
  <td class="negrita centrado">Respuesta motora:</td>
  <td class="negrita centrado">Glasgow:</td>
</tr>
<tr>
  <td class="centrado"><?=$triage['resp_ocular']?></td>
  <td class="centrado"><?=$triage['resp_verbal']?></td>
  <td class="centrado"><?=$triage['resp_motora']?></td>
  <td class="centrado"><?=$triage['resp_ocular']+$triage['resp_verbal']+$triage['resp_motora']?>/15</td>
</tr>
</tr>
<tr>
  <td class="negrita centrado" colspan="2">Conducta:</td>
  <td class="negrita centrado" colspan="2">Sala de espera:</td>
  <td class="negrita centrado">Clasificación:</td>
</tr>
<tr>
  <td class="centrado" colspan="2"><?=$triage['conducta']?></td>
  <td class="centrado" colspan="2"><?=$triage['sala']?></td>
  <td class="centrado">
    <?php 
      switch ($triage['clasificacion']){
        case '1':
          echo $triage['clasificacion'].' - Rojo';
          break;
        case '2':
          echo $triage['clasificacion'].' - Amarillo';
          break;
        case '3':
          echo $triage['clasificacion'].' - Verde';
          break;
        default:
          echo 'No registra clasificaci&oacute;n';
      }
    ?>
  </td>
</tr>
</table>

<!--------------consulta_inicial-------------------->
<h4>Atenci&oacute;n inicial del paciente</h4>
<h5>Datos de la historia cl&iacute;nica</h5>
<table id="interna">
  <tr>
    <td class="negrita">Motivo de la consulta:</td>
    <td class="centrado"><?=$consulta['motivo_consulta']?></td>
    <td class="negrita">Enfermedad actual:</td>
    <td class="centrado"><?=$consulta['enfermedad_actual']?></td>
    <td class="negrita">Revisi&oacute;n sistemas:</td>
    <td class="centrado"><?=$consulta['revicion_sistemas']?></td>
  </tr>
</table>
<h5>Datos de los antecedentes</h5>
<table id="interna">
<tr>
  <td class="negrita">Antecedentes patol&oacute;gicos:</td>
  <td class="centrado"><?=$consulta['ant_patologicos']?></td>
  <td class="negrita">Antecedentes farmacol&oacute;gicos:</td>
  <td class="centrado"><?=$consulta['ant_famacologicos']?></td>
</tr>
<tr>
  <td class="negrita">Antecedentes tóxico al&eacute;rgicos:</td>
  <td class="centrado"><?=$consulta['ant_toxicoalergicos']?></td>
  <td class="negrita">Antecedentes quir&uacute;rgicos:</td>
  <td class="centrado"><?=$consulta['ant_quirurgicos']?></td>
</tr>
<tr>
  <td class="negrita">Antecedentes familiares:</td>
  <td class="centrado"><?=$consulta['ant_familiares']?></td>
  <td class="negrita">Antecedentes ginecol&oacute;gicos:</td>
  <td class="centrado"><?=$consulta['ant_ginecologicos']?></td>
</tr>
<tr>
  <td class="negrita">Antecedentes otros:</td>
  <td class="centrado" colspan="3"><?=$consulta['ant_otros']?></td>
</tr>
</table>
<h5>Datos del ex&aacute;men f&iacute;sico</h5>
<table id="interna">
<tr>
  <td class="negrita">Condiciones generales:</td>
  <td colspan="5" class="centrado"><?=$consulta['motivo_consulta']?></td>
</tr>
<tr>
  <td colspan="6" class="negrita centrado">Signos vitales</td>
</tr>
<tr>
  <td class="negrita centrado">Frecuencia cardiaca:</td>
  <td class="negrita centrado">Frecuencia respiratoria:</td>
  <td class="negrita centrado">Tensi&oacute;n arterial:</td>
  <td class="negrita centrado">Temperatura:</td>
  <td colspan="2" class="negrita centrado">Pulsioximetr&iacute;a (SPO2):</td>
</tr>
<tr>
  <td class="centrado"><?=$consulta['frecuencia_cardiaca']?> X min</td>
  <td class="centrado"><?=$consulta['frecuencia_respiratoria']?> X min</td>
  <td class="centrado"><?=$consulta['ten_arterial_s'].' / '.$consulta['ten_arterial_d']?></td>
  <td class="centrado"><?=$consulta['temperatura']?> &deg;C</td>
  <td colspan="2" class="centrado"><?=$consulta['spo2']?> %</td>
</tr>
<tr>
  <td class="negrita">Ex&aacute;men cabeza:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_cabeza']?></td>
  <td class="negrita">Ex&aacute;men ojos:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_ojos']?></td>
</tr>
<tr>
  <td class="negrita">Ex&aacute;men oral:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_oral']?></td>
  <td class="negrita">Ex&aacute;men cuello:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_cuello']?></td>
</tr>
<tr>
  <td class="negrita">Ex&aacute;men dorso:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_dorso']?></td>
  <td class="negrita">Ex&aacute;men torax:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_torax']?></td>
</tr>
<tr>
  <td class="negrita">Ex&aacute;men abdomen:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_abdomen']?></td>
  <td class="negrita">Ex&aacute;men genitourinario:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_genito_urinario']?></td>
</tr>
<tr>
  <td class="negrita">Ex&aacute;men extremidades:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_extremidades']?></td>
  <td class="negrita">Ex&aacute;men neurol&oacute;gico:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_neurologico']?></td>
</tr>
<tr>
  <td class="negrita">Ex&aacute;men piel:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_piel']?></td>
  <td class="negrita">Ex&aacute;men mental:</td>
  <td colspan="2" class="centrado"><?=$consulta['exa_mental']?></td>
</tr>
</table>
<h5>Datos de la impresi&oacute;n diagn&oacute;stica</h5>
<table id="interna">


<?php
  $i = 1;
  if(count($dx) > 0)
    {
      foreach($dx as $d)
      {
?>
<tr>
  <td class="negrita">Diagnostico <?=$i?>:</td>
  <td colspan="3" class="centrado"><?='<strong>'.$d['id_diag'].'</strong> '.$d['diagnostico']?></td>
</tr>
<?php
      }
    }
  else
    {
?>
<tr>
  <td colspan="2">No hay diagnosticos asociados a la consulta inicial</td>
</tr>
<?php
    }
?>

<tr>
  <td class="negrita">An&aacute;lisis:</td>
  <td class="centrado"><?=$consulta['analisis']?></td>
  <td class="negrita">Conducta:</td>
  <td class="centrado"><?=$consulta['conducta']?></td>
</tr>
</table>

<!--------------evoluciones------------------------->

<h4>Evoluci&oacute;n del paciente</h4>
<h5>Datos de la evoluci&oacute;n</h5>

<?php
foreach($evo as $evos)
{
?>
<table id="interna">
  <tr>
    <td class="negrita">Fecha y hora:</td>
    <td class="centrado"><?=$evos['fecha_evolucion']?></td>
    <td class="negrita">M&eacute;dico:</td>
    <td class="centrado"><?=$evos['primer_nombre'].' '.$evos['segundo_nombre'].' '.$evos['primer_apellido'].' '.$evos['segundo_apellido']?></td>
  </tr>
  <tr>
    <td class="negrita">Especialidad:</td>
    <td class="centrado"><?=$evos['esp']?></td>
    <td class="negrita">Tipo evolución:</td>
    <td class="centrado"><?=$evos['tipo_evolucion']?></td>
  </tr>
  <tr>
    <td class="negrita">Subjetivo:</td>
    <td class="centrado"><?=$evos['subjetivo']?></td>
    <td class="negrita">Objetivo:</td>
    <td class="centrado"><?=$evos['objetivo']?></td>
  </tr>
  <tr>
    <td class="negrita">Análisis:</td>
    <td class="centrado"><?=$evos['analisis']?></td>
    <td class="negrita">Conducta:</td>
    <td class="centrado"><?=$evos['conducta']?></td>
  </tr>
</table>
<br />
<?php
}
?>

<h5>Datos de los diagn&oacute;sticos</h5>
<table id="interna">
<?php
	$i = 1;
  if(count($dxEvo) > 0)
  {
    foreach($dxEvo as $d)
    {
			foreach($d as $diag)
			{
?>
      <tr>
        <td class="negrita" style="width:130px">Diagn&oacute;stico <?=$i?>:</td>
        <td><strong><?=$diag['id_diag'].' '?></strong><?=$diag['diagnostico']?></td>
      </tr>
<?php
      	$i++;
			}
    }
  }
  else
  {
?>
    <tr>
      <td colspan="2">No hay diagn&oacute;sticos asociados a la evoluci&oacute;n</td>
    </tr>
<?php
  }
?>
</table>

<!--------------ordenamientos----------------------->

<h4>Orden M&eacute;dica del paciente</h4>
<h5>Datos de la orden m&eacute;dica</h5>
<table id="interna">
<tr>
	<td class="negrita centrado">Orden:</td>
	<td class="negrita centrado">Dieta:</td>
  <td class="negrita centrado">Posici&oacute;n de la cama:</td>
  <td class="negrita centrado">Suministro de Oxigeno:</td>
  <td class="negrita centrado">Suministro de l&iacute;quidos:</td>
</tr>
<?php
$i = 0;
foreach($orden as $ord)
{
?>
<tr>
	<td class="centrado"><?=$i+1?></td>
  <td class="centrado">
  <?php
	foreach($ordenDietas[$i] as $data)
	{
		foreach($dietas as $d)
		{
			if($data['id_dieta'] == $d['id_dieta'])
			{
				echo $d['dieta']."<br>";
			}
		}
	}
  ?>
  </td>
  <td class="centrado">
    Cabecera: <strong><?=$ord['cama_cabeza']?></strong>&deg;<br/>
    Pie de cama: <strong><?=$ord['cama_pie']?></strong>&deg;
  </td>
  <td class="centrado">
<?php
	if($ord['oxigeno'] == 'SI')
	{
?>
		Tipo de Oxigeno a suministrar:	<strong><?=$ord['tipoO2']?></strong><br/>
		Cocentraci&oacute;n de oxigeno: <strong><?=$ord['valorO2']?></strong>
<?php
	}
	else
	{
		echo $ord['oxigeno'];
	}
?>
  </td>
  <td class="centrado"><?=$ord['liquidos']?></td>
</tr>
<?php
$i++;
}
?>
</table>
<h5>Datos de los cuidados generales y enfermer&iacute;a</h5>
<table id="interna">
<?php
	$i = 0;
	foreach($ordenCuid as $d)
	{
		foreach($ordenCuid[$i] as $d)
		{
			$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia_cuidado']);
			$d['cuidado'] = $this->urgencias_model->obtenerCuidadoDetalle($d['id_cuidado']);
?>  
  <tr>
    <td class="negrita" style="width:15%">Cuidado:</td>
    <td class="centrado" style="width:35%"><?=$d['cuidado']?></td>
    <td class="negrita" style="width:15%">Frecuencia:</td>
    <td class="centrado" style="width:35%"><?="Cada ".$d['frecuencia_cuidado']." ".$d['uni_frecuencia']?></td>
  </tr>
<?php
		}
		$i++;
	}
?>
  <tr>
    <td class="negrita">Otros cuidados:</td>
    <td colspan="3">
		<?php
    foreach($orden as $ord)
		{
			echo $ord['cuidados_generales'].'<br>';
		}
		?>
    </td>
  </tr>
</table>
<h5>Datos de los medicamentos</h5>
<?php
$i = 0;
foreach($ordenMedi as $d)
{
?>
<table id="interna">
<?php
	foreach($ordenMedi[$i] as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
?>
  <tr>
    <td class="negrita centrado">Medicamento:</td>
    <td class="negrita centrado">Dosis:</td>
    <td class="negrita centrado">Unidad:</td>
    <td class="negrita centrado">Frecuencia:</td>
    <td class="negrita centrado">V&iacute;a:</td>
  </tr>
  <tr>
    <td class="centrado"><?=$d['medicamento']?></td>
    <td class="centrado"><?=$d['dosis']?></td>
    <td class="centrado"><?=$d['unidad']?></td>
    <td class="centrado"><?="Cada ".$d['frecuencia']." ".$d['uni_frecuencia']?></td>
    <td class="centrado"><?=$d['via']?></td>
  </tr>
  <tr>
    <td class="negrita">Observaciones:</td>
    <td class="centrado" colspan="4"><?=$d['observacionesMed']?></td>
  </tr>
<?php
	}
?>
</table>
<br />
<?php
	$i++;
}
?>
<h5>Insumos y Dispositivos M&eacute;dicos</h5>
<?php
$i = 0;
foreach($ordenInsumos as $d)
{
?>
<table id="interna">
  <tr>
    <td class="negrita centrado" style="width:30%">Insumo:</td>
    <td class="negrita centrado" style="width:30%">Cantidad:</td>
    <td class="negrita centrado" style="width:40%">Observaciones:</td> 
  </tr>
<?php
	foreach($ordenInsumos[$i] as $d)
	{
?>
  <tr>
    <td class="centrado"><?=$d['insumo']?></td>
    <td class="centrado"><?=$d['observaciones']?></td>
    <td class="centrado"><?=$d['cantidad']?></td>
  </tr>
<?php
	}
?>
</table>
<br />
<?php
	$i++;
}
?>
<h5>Procedimientos y ayudas diagn&oacute;sticas</h5>
<?php
$i = 0;
foreach($ordenCups as $d)
{
?>
<table id="interna">
  <tr>
    <td class="negrita centrado" style="width:30%">Procedimiento:</td>
    <td class="negrita centrado" style="width:30%">Cantidad:</td>
    <td class="negrita centrado" style="width:40%">Observaciones:</td>
  </tr>
<?php
	foreach($ordenCups[$i] as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
?>
  <tr>
    <td class="centrado"><?=$d['procedimiento']?></td>
    <td class="centrado"><?=$d['cantidadCups']?></td>
    <td class="centrado"><?=$d['observacionesCups']?></td>
  </tr>
<?php
	}
?>
</table>
<br />
<?php
}
?>
<!--------------epicrisis--------------------------->

<?php
if(!empty($epicrisis))
{
?>
<h4>Datos de la epicrisis</h4>
<table id="interna">
  <tr>
    <td class="negrita">Ex&aacute;menes auxiliares de diagn&oacute;sticos solicitados:</td>
    <td colspan="3"><?=$epicrisis['examenes_auxiliares']?></td>
  </tr>
  <tr>
		<td class="negrita">Tratamiento recibido:</td>
    <?php
			if(count($mediAtencion) > 0)
			{
		?>
    		<td colspan="3">
    <?php
				$i = 0;
				foreach($mediAtencion as $d)
				{
					if(count($mediAtencion) > $i+1)
						echo $this->urgencias_model->obtenerNomMedicamento($d['atc']).'<br><br>';
					else
						echo $this->urgencias_model->obtenerNomMedicamento($d['atc']);
						
					$i++;
				}
		?>
    		</td>
    <?php
			}
			else
			{
		?>
   			<td colspan="3">&nbsp;</td>
    <?php
			}
		?>
  </tr>
  <tr>
    <td class="negrita">Evoluci&oacute;n:</td>
    <td><?=$epicrisis['evolucion']?></td>
    <td class="negrita">Traslado del paciente:</td>
    <td>
    <?php
			echo $epicrisis['traslado'];
			if($epicrisis['traslado'] == 'SI')
			{
				echo '<br>Nivel de traslado: ' , $epicrisis['nivel_traslado'];
				echo '<br>Lugar traslado: ' , $epicrisis['lugar_traslado'];
			}
		?>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="negrita centrado">Recomendaciones:</td>
  </tr>
  <tr>
    <td class="negrita">Cita de control en Consulta Externa:</td>
    <td>
    <?php
			echo $epicrisis['cita_con_ext'];
			if($epicrisis['cita_con_ext'] == 'SI')
			{
		?>
        Con: <?=$epicrisis['descripcion']?>
        <br />
        En cuantos días: <?=$epicrisis['cita_conext']?>
		<?php
			}
		?>
    </td>
    <td class="negrita">Cita de control hospital local:</td>
    <td>
    <?php
			echo $epicrisis['cita_hosp_local'];
			if($epicrisis['cita_hosp_local']== 'SI')
			{
		?>
				Municipio: <?=$epicrisis['municipio_cita']?>
        <br />
        En cuantos días: <?=$epicrisis['cita_hopslocal']?>
		<?php
			}
		?>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="negrita centrado">Destino:</td>
  </tr>
  <tr>
    <td class="negrita">Destino del paciente:</td>
    <td><?=$epicrisis['destino']?></td>
    <td class="negrita">Observaciones sobre el destino:</td>
    <td><?=$epicrisis['obser_destino']?></td>
  </tr>
  <tr>
    <td colspan="4" class="negrita centrado">Responsable:</td>
  </tr>
  <tr>
    <td class="negrita">Certifico que el cuadro cl&iacute;nico anteriormente descrito junto con su tratamiento fueron consecuencia de:</td>
    <td class="negrita">M&eacute;dico que realiza la salida:</td>
    <td class="negrita">C&oacute;digo:</td>
    <td class="negrita">Fecha y hora epicrisis:</td>
  </tr>
  <tr>
    <td><?=$origen['origen']?></td>
    <td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td>
    <td><?=$medico['tarjeta_profesional']?></td>
    <td><?=$epicrisis['fecha_egreso']?></td>
  </tr>
</table>
<?php
}
?>

<?php $this -> load -> view('impresion/fin'); ?>
