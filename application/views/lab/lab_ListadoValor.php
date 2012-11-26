<script type="text/javascript">
window.addEvent("domready", function(){
var dato = <?=$id ?>;
 obtenerOrden(dato);
 var exValidatorA = new fValidator("formulario");
	 
});

function obtenerOrden(dato)
{
  var sala = dato;
  if(sala == 0){
    return false;
  }
  
  var var_url = '<?=site_url()?>/lab/lab_adm_clinicos/listadoValores/'+dato;
  var ajax1 = new Request(
  {
    url: var_url,
    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_listado_valor'+dato).set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}


</script>

<div id="div_listado_valor<?=$id ?>">

</div>