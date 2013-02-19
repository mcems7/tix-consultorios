<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de Urgencias - Remision del paciente</h4>
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
  

</table>
<?=br()?>
<table id="interna">
 <tr>
    <td class="negrita">Resumen de anamnesís y examen fisico:</td>
    <td colspan="3"><?=$remision['resumen_anamnesis']?></td>
  </tr>
  <tr>
    <td class="negrita">Ex&aacute;menes auxiliares de diagn&oacute;sticos solicitados:</td>
    <td colspan="3"><?=$remision['examenes_auxiliares']?></td>
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
  </table>
  


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
    <td class="negrita">Complicaciones:</td>
    <td colspan="3"><?=$remision['complicaciones']?></td>
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
    <td class="negrita">Motivo de remisión:</td>
    <td colspan="3"><?=$remision['motivo_remision']?></td>
  </tr>
 
  
  <tr>
    <td colspan="4" class="negrita centrado">Responsable:</td>
  </tr>
 <tr><td class="campo">Médico que realiza la salida:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Código:</td>
<td><?=$medico['tarjeta_profesional']?></td></tr>
<tr><td class="campo">Fecha y hora remision:</td>
<td><?=$remision['fecha_egreso']?></td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>  
  
</table>

<?php $this -> load -> view('impresion/fin'); ?>
