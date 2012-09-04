<?php
$CI = &get_instance();  
$CI -> load -> model('impresion/hospi/hospi_impresion_model');
$empresa = $CI->hospi_impresion_model -> obtenerEmpresa();
?>

</td>
  </tr>
  <tr>
    <td colspan="2" class="pie_pagina">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="pie_izq"></td>
    <td class="pie_centro">
    Un producto de TIX S.A.S Su aliado en tecnología <a href="http://www.tix.com.co" target="_blank">www.tix.com.co</a>
<p>Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0 <a href="<?=base_url()?>resources/licencia.html" target="_blank">Ver términos de la licencia</a> <img src="<?=base_url()?>resources/images/gplv3-88x31.png" width="88" height="31" /></p>
    </td>
    <td class="pie_der"></td>
  </tr>
</table>

 </td>
  </tr>
</table>
</center>
</body>
</html>
