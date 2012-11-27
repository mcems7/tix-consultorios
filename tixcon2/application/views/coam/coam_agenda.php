<link rel="stylesheet" href="http://200.110.171.85/yage_sanpio/resources/styles/calendario_agenda.css" type="text/css" media="screen" />
<center>
<table width="100%" class="tabla_form">
<tr><th>Agenda</th></tr>
<tr><td>
<?php
		$d = array(
3 => 'http://your-site.com/news/article/2006/03/<br>http://your-site.com/news/article/2006/03/',
7 => 'http://your-site.com/news/article/2006/07/',
19 => 'http://your-site.com/news/article/2006/13/',
26 => 'http://your-site.com/news/article/2006/26/'
);
	
echo	$this->calendar->generate(2012,4,$d);
?>
</td></tr>
<tr><td class="linea_azul">&nbsp;</td></tr>
  <tr><td align="center">
  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
  </td></tr>
</table>
&nbsp;
</center>