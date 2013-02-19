<html>
<head>
<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=600, top=10, left=140";
window.open(pagina,"Mi_ventana",opciones);
}
</script>
</head>
<body>
<a href="javascript:Abrir_ventana('<?=site_url().'/impresion/impresion/consultaTriage/10' ?>')">
  <font size="5" face="Verdana">Imprimir triage</font></a>
<br />
<a href="javascript:Abrir_ventana('<?=site_url().'/impresion/impresion/consultaInicial/10' ?>')">
  <font size="5" face="Verdana">Imprimir consulta inicial</font></a>
<br />
<a href="javascript:Abrir_ventana('<?=site_url().'/impresion/impresion/consultaEvolucion/25' ?>')">
  <font size="5" face="Verdana">Imprimir evoluciones</font></a>
<br />
<a href="javascript:Abrir_ventana('<?=site_url().'/impresion/impresion/consultarOrden/44' ?>')">
  <font size="5" face="Verdana">Imprimir ordenamiento m&eacute;dico</font></a>
<br />
<a href="javascript:Abrir_ventana('<?=site_url().'/impresion/impresion/consultaEpicrisis/5' ?>')">
  <font size="5" face="Verdana">Imprimir epicrisis</font></a>
<br />
<br />
<br />
<a href="javascript:Abrir_ventana('<?=site_url().'/impresion/impresion/consultaMedicamentos/1' ?>')">
  <font size="5" face="Verdana">Formato medicamentos</font></a>
</body>
</html>
