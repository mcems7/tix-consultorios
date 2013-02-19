<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mensaje del sistema</title>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/mootools.js"></script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
Abrir_ventana();
document.location = "<?php echo $urlRegresar; ?>";
	});
////////////////////////////////////////////////////////////////////////////////
function Abrir_ventana(){
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=600, top=10, left=140";
window.open("<?=site_url()?>/impresion/impresion/consultaTriage/<?=$id_atencion?>/4","Mi_ventana",opciones);
}
</script>
</head>

<body style="background-color:#81A11F">
<script type="text/javascript">
//Abrir_ventana();
</script>
</body>
</html>
