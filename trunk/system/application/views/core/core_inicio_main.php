<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
              
				
				
				.cvoptions {
    background-color: rgba(0, 0, 0, 0.6);
    display: block;
    list-style: none outside none;

    padding: 10px 0px 10px 7px;
    position: fixed;
    top: 40%;
	right:0%;
    width: 30px;
    z-index: 100001 !important;
}
.cvoptions li {
    float: right;
    height: 40px;
    margin: 1px 0 0;
    padding: 0;
    width: 40px;
}
.cvoptions li a {
    display: block;
    height: 40px;
    text-indent: -9999px;
    width: 40px;
	
}
</style>
<script language="javascript">
var ajax_list_externalFile = '<?=site_url()?>/';

function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=600, top=10, left=140";
window.open(pagina,"Mi_ventana",opciones);
}
</script>

<script type="text/javascript" src="<?=base_url()?>resources/js/mootools1-2-0.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/fValidator.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/validaciones.js"></script>
<link rel="Shortcut Icon" href="<?=base_url()?>resources/img/e.png" type="image/x-icon" />
<link rel="stylesheet" href="<?=base_url()?>resources/menu/menu_style.css" type="text/css" />

<link rel="stylesheet" href="<?=base_url()?>resources/styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/general.css" type="text/css" media="screen" />
<!--Mediabox-->
<script type="text/javascript" src="<?=base_url()?>resources/js/mediabox.js"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>resources/styles/mediaboxAdvBlack.css" media="screen"></LINK>
<!--Fin mediabox-->
<!--Calendario-->
<link type="text/css" rel="stylesheet" href="<?=base_url()?>resources/js/calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="<?=base_url()?>resources/js/calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script>
<!--Fin Calendario-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>YAG&Eacute; - Sistema de gesti&oacute;n hospitalaria</title>
</head>

<body>
<div id="div_precarga" class="capa_ajax" style="display:none">
		<img src="<?=base_url()?>resources/img/loading2.gif" alt="Cargando..."/>
		<br />Por favor espere mientras se procesa su solicitud ...
</div>
<center>
<?php
$tama = 1000;
$menua = $tama*0.3;
$menub = $tama*0.4;
$centroa = $tama * $menua;
$centrob = $tama - $menub;
?>
<table width="<?=$tama?>" class="tabla_principal" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="right" >
    <img  src="<?=base_url()?>resources/img/cabezotegrande.png"/>
    &nbsp;
    </td>
  </tr>
   <?php
	
   
	if($this->session->userdata('username'))
	{
	?>
  <tr>
    <td class="menu_principal" width="<?=$menua?>">
    <?php
		$this->load->model('core/Usuario');
		$usr = $this->Usuario->obtenerNombreTercero($this->session->userdata('id_usuario'));
	?>
    <span class="usuario_bienvenida">
    Bienvenido:<br /></span>
     <span class="usuario_nombre">
    <?=$usr['primer_nombre']." ".$usr['segundo_nombre']." ".$usr['primer_apellido']." ".$usr['segundo_apellido']?>
    </span>
   <?=$this->load->view('core/menu_principal')?>
   </td><td width="<?=$centroa?>" class="bloque_centro">
   <?php
	}else{												
	?> 
     <tr>
  <td class="bloque_centro" width="<?=$centrob?>">
    <?php } ?>
    

