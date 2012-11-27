<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de Urgencias - Declaraci&oacute;n de retiro voluntario</h4>
<h5>IDENTIFICACI&Oacute;N</h5>
<table id="interna" width="100%">
  <tr>
    <td class="negrita">Apellidos:</td>
    <td class="centrado"><?=$tercero['primer_apellido'].' '.$tercero['segundo_apellido']?></td>
    <td class="negrita">Nombres:</td>
    <td class="centrado"><?=$tercero['primer_nombre'].' '.$tercero['segundo_nombre']?></td>
    <td class="negrita">Documento:</td>
    <td class="centrado"><?=$tercero['tipo_documento'].' '.$tercero['numero_documento']?></td>
  </tr>
  <tr>
    
    <td class="negrita">G&eacute;nero:</td>
    <td class="centrado"><?=$paciente['genero']?></td>
    <td class="negrita">Fecha de nacimiento:</td>
    <td class="centrado"><?=$tercero['fecha_nacimiento']?></td>
    <td class="negrita">Edad:</td>
    <td class="centrado"><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
  </tr>
</table>
<h5>DECLARACI&Oacute;N</h5>
<table border="1" width="100%">
<tr>
<td style="padding:20px">

<table border="0" width="100%">
<tr><td style="padding:30px 0px 30px 0px; text-align:right">EL (LA) SUSCRITO (A)</td><td style="padding:5px;">_______________________________________________________</td></tr>
</table>
<table border="0" width="100%">
<tr><td style="padding:10px 0px 10px 0px">
DECLARA QUE HABIENDO SIDO DEBIDAMENTE INFORMADO (A) SOBRE LOS RIESGOS Y POSIBLES COMPLICACIONES DE SALUD QUE IMPLICA EL RETIRO VOLUNTARIO DE ESTA INSTITUCIÓN:
</td></tr>
<tr><td style="padding:10px 0px 10px 0px; border-bottom-style:ridge; border-bottom-width:thin; text-align:center; font-weight:bold">
EMPRESA SOCIAL DEL ESTADO HOSPITAL DEPARTAMENTAL UNIVERSITARIO DEL QUINDIO SAN JUAN DE DIOS ARMENIA Q
</td></tr>
</table>
<table border="0" width="100%">
<tr><td style="padding:20px 0px 20px 0px">
BAJO MI PROPIA RESPONSABILIDAD DECIDO ABANDONARLA Y EN CONSECUENCIA DECLARO QUE NI LA INSTITUCIÓN NI SU PERSONAL SERÁN RESPONSABLES EN CASO DE COMPLICACIONES.
</td></tr>
</table>
<table border="0" width="100%">
<tr><td style="padding:20px 0px 40px 0px">
FIRMARDO:
</td></tr>
<tr><td style="padding:0px 0px 10px 0px; border-bottom-style:solid; border-bottom-width:thin; text-align:center; font-weight:bold">&nbsp;
</td></tr>
</table>
<table border="0" width="100%">
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CÉDULA DE CIUDADANIA:</td>
<td style="padding:30px 0px 0px 0px; border-bottom-style:solid; border-bottom-width:thin; text-align:center; font-weight:bold">&nbsp;
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DE</td>
<td style="padding:30px 0px 0px 0px; border-bottom-style:solid; border-bottom-width:thin; text-align:center; font-weight:bold">&nbsp;
</td>
</tr>
</table>
<br />
<br />
</td>
</tr>
</table>
<?php $this -> load -> view('impresion/fin'); ?>
