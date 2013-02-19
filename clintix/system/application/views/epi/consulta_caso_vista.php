<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta reporte</title>
<link rel="stylesheet" href="<?=base_url()?>resources/styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/general.css" type="text/css" media="screen" />
</head>

<body>
<center>
<table width="90%" class="tabla_form" cellpadding="0" cellspacing="0">
<tr><th>Detalle del reporte de vigilancia</th></tr>
  <tr>
    <td align="center">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo" >Fecha y hora:</td><td><?=$repo['fecha']?></td></tr>
<tr><td class="campo" >Medico:</td><td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo" >Diagnostico:</td><td><?=$repo['dx']?></td></tr>
<tr><td class="campo" >Servicio:</td><td><?=$repo['nombre_servicio']?></td></tr>
<tr><td class="linea_azul" colspan="2"></td></tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
<td class="campo">Tipo usuario:</td>
<td>
<?
foreach($tipo_usuario as $d)
	{
		if($paciente['id_cobertura'] == $d['id_cobertura'])
		{
			echo $d['cobertura'];
		}
	}
?>
</td></tr>
<tr><td class="campo">Departamento:</td><td><?=$tercero['depa']?></td><td class="campo">Municipio:</td><td><?=$tercero['nombre']?></td></tr>
<tr><td class="campo">Barrio / Vereda:</td><td><?=$tercero['vereda']?></td><td class="campo">Zona:</td><td><?=$tercero['zona']?></td></tr>
<tr><td class="campo">Direcci&oacute;n:</td><td><?=$tercero['direccion']?></td><td class="campo">Teléfono:</td><td><?=$tercero['telefono']?></td></tr>
<tr><td class="campo">Celular:</td><td><?=$tercero['celular']?></td></tr>
<tr><td class="linea_azul" colspan="4"></td></tr>
</table>
    


</td>
</tr>
<tr><td align="center">
<br />
<input name="bc" type="button" value="Cerrar ventana" onclick="window.close()" /></td></tr>
<br />
</table>
</center>
</body>
</html>
