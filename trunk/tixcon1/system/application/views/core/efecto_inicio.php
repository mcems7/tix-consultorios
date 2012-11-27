<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script language="javascript">
var ajax_list_externalFile = '<?=site_url()?>/';

function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=600, top=10, left=140";
window.open(pagina,"Mi_ventana",opciones);
}
</script>
 <style type="text/css">
              
				
				
				.cvoptions {
    background-color: rgba(0, 0, 0, 0.6);
    display: block;
    list-style: none outside none;

    padding: 0px 0px 0px 0;
    position: fixed;
    top: 40%;
	right:0%;
    width: 23px;
    z-index: 100001 !important;
}
.cvoptions li {
    float: right;
    height: 23px;
    margin: 1px 0 0;
    padding: 0;
    width: 23px;
}
.cvoptions li a {
    display: block;
    height: 23px;
    text-indent: -9999px;
    width: 23px;
}
.cvoptions li a.emailbutton {
    background: url("img/b-email.gif") no-repeat scroll 0 0 transparent;
}
.cvoptions li a.emailbutton:hover {
    background: url("img/b-email.gif") no-repeat scroll 0 -23px transparent;
}
.cvoptions li a.pdfbutton {
    background: url("img/b-pdf.gif") no-repeat scroll 0 0 transparent;
}
.cvoptions li a.pdfbutton:hover {
    background: url("img/b-pdf.gif") no-repeat scroll 0 -23px transparent;
}
.cvoptions li a.printbutton {
    background: url("img/b-print.gif") no-repeat scroll 0 0 transparent;
}
.cvoptions li a.printbutton:hover {
    background: url("img/b-print.gif") no-repeat scroll 0 -23px transparent;
}

                </style>
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

<table  class="tabla_principal" cellpadding="0" cellspacing="0">

<td class="bloque_centro">
  
    

