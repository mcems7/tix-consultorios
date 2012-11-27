<?php $this -> load -> view('impresion/hospi/hospi_inicio'); ?>
<h4>Servicio de hospitalización - Epicrisis</h4>
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
<?=br()?>
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
		echo $epicrisis['estado_salida'];
		
		if($epicrisis['estado_salida'] == 'Muerto')
			echo '&nbsp;' , $epicrisis['tiempo_muerto'];
	?>
    </td>
    <td class="negrita">Incapacidad funcional:</td>
    <td class="centrado"><?php
echo $epicrisis['incapacidad'];
if($epicrisis['incapacidad'] == 'SI')
	echo nbs(),$epicrisis['incapacidad'], nbs(),'D&iacute;as';
?></td>
  </tr>
</table>
<?=br()?>
<table id="interna">
<tr><td colspan="2" class="negrita centrado">DIAGN&Oacute;STICOS</td></tr>
  <tr>
    <td class="negrita centrado">De ingreso:</td>
    <td class="negrita centrado">De egreso:</td>
  </tr>
  <tr>
    <td>
   	<?php
		if(count($dxI) > 0)
		{
		?>
    	<ol>
  <?php
			foreach($dxI as $d)
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
		if(count($dxE) > 0)
		{
		?>
    	<ol>
  <?php
			foreach($dxE as $d)
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
<?=br()?>
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
  <td class="negrita centrado" colspan="4">EVOLUCI&Oacute;N</td></tr>
<tr><td colspan="4">
<?php
	foreach($evo as $d)
	{
		$this->load->view('impresion/epi_evolucion',$d);	
	}
?>
</td></tr>
    <tr><td class="negrita">Traslado del paciente:</td>
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
<?php $this -> load -> view('impresion/hospi/hospi_fin'); ?>