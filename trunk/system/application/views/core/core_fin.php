<?php
$CI = &get_instance();  
$CI -> load -> model('impresion/hospi/hospi_impresion_model');
$empresa = $CI->hospi_impresion_model -> obtenerEmpresa();
?>

</td>
  </tr>
  <tr>
    <td colspan="2" class="pie_pagina">
<?=$empresa['razon_social'].br()?>
Proyecto OPUS LIBERTATI&nbsp;<?=anchor("http://www.opuslibertati.org","http://www.opuslibertati.org");?>
<?=br()?>    
<?=$empresa['direccion'].', '.$empresa['municipio'].' - '.$empresa['departamento'].br()?>
Telefonos:&nbsp;(<?=$empresa['indicativo'].') '.$empresa['telefono1'].br()?>
Email:<?=nbs().mailto($empresa['email'],$empresa['email'])?>
<p>Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0 <a href="<?=base_url()?>resources/licencia.html" target="_blank">Ver términos de la licencia</a> <img src="<?=base_url()?>resources/images/gplv3-88x31.png" width="88" height="31" /></p> </td>
  </tr>
</table>
</center>
</body>
</html>
