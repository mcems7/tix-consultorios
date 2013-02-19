<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de Urgencias - Imaginolog&iacute;a</h4>
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
    <td class="negrita">G&eacute;nero:</td>
    <td class="centrado"><?=$paciente['genero']?></td>
  </tr>
  <tr>
    <td class="negrita">Fecha de nacimiento:</td>
    <td class="centrado"><?=$tercero['fecha_nacimiento']?></td>
    <td class="negrita">Edad:</td>
    <td class="centrado"><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
  </tr>
</table>
<h5>Solicitado por</h5>
<table id="interna">
  <tr>
    <td class="negrita">Fecha y hora de la orden:</td>
    <td class="centrado"><?=$orden['fecha_creacion']?></td>
    <td class="negrita">M&eacute;dico tratante:</td>
    <td class="centrado"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td>
  </tr>
  <tr>
    <td class="negrita">Tipo m&eacute;dico:</td>
    <td class="centrado"><?=$medico['tipo_medico']?></td>
    <td class="negrita">Especialidad:</td>
    <td class="centrado"><?=$medico['especialidad']?></td>
  </tr>
</table>



<table id="interna">
  <tr>
    <td class="negrita centrado" style="width:100%" colspan="2"><h3>Procedimientos y ayudas diagn&oacute;sticas</h3></td>
 
  </tr>
  <tr>
    <td class="negrita" style="width:20%">Enfermedad actual:<td><?=$enfermedad_actual?></td></td>
 
  </tr>

<tr><td class="negrita" style="width:20%">An&aacute;lisis:</td>
<td><?=$analisis;?></td></tr>

<tr>

    <td class="negrita" style="font-size:16px; width:50%">Examen solicitado:</td>
    
    <td class="negrita" style="font-size:16px ; width:50%">Impresion Dx:</td>
   
  </tr>
<?php

	foreach($ordenCupsImagenes as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		
		if($imagenes != null){
		if(in_array($d['id'],$imagenes)){
			
			
?>
  <tr height="100%">
 
     <td width="50%"><?php if(isset($d['procedimiento'])){
		echo $d['procedimiento'];
		}else{
			echo "No se selecciono procedimiento";
			
			}?></td>
	<td width="50%"><?php if(isset($d['observacionesCups'])){
		echo $d['observacionesCups'];
		}else{
			echo "No se selecciono procedimiento";
			
			}?></td>
  </tr>
<?php
	   }
		}else{
		?>
		<tr height="100%">
 
     <td width="100%"><?php 
			echo "No se selecciono procedimiento";
			?></td>
	<td width="100%"><?php 
			echo "No se selecciono procedimiento";
			?></td>
  </tr>
        
        <?php
		}
	}	
	
?>



</table>

<?php $this -> load -> view('impresion/fin'); ?>
