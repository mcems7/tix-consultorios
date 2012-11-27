  <script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>

<script type="text/javascript">


////////////////////////////////////////////////////////////////////////////////
function ValorList()
{
  
  var var_url = '<?=site_url()?>/atencion/aten_adm_hc/AgregarValorList/'
  var ajax1 = new Request(
  {
    url: var_url,
    method: 'post',
    data:  $('formulario2').toQueryString(),
    onRequest: function (){$('div_precarga').style.display = "block";},
 onSuccess: function(html){$('div_tipos_clinico').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}
////////////////////////////////////////////////////////////////////////////////



function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////



window.addEvent('domready', function() {
	

	
   //aquí las acciones que quieras realizar cuando el DOM esté listo
   tree = new Mif.Tree({
	   forest: true,
container: $('tree_container'),// tree container
types: {// node types
folder:{
openIcon: 'mif-tree-open-icon',//css class open icon
closeIcon: 'mif-tree-close-icon'// css class close icon
}
},
dfltType:'folder',//default node type
height: 18,//node height
		onRename: function(node, newName, oldName){
			alert(oldName + ' Renombrado Por ' + newName);	
			var id=node.id;	
			
			cambionombre(newName,id);
			
		}
});
var json = 
<?php 
		echo $json;
		?>



// load tree from json.
tree.load({
json: json
}); 
$('rename').addEvent('click', function(){
		var node = tree.selected;
		
	    if(!node) return;
	    node.rename();
	});
	
$('contenedor_lab').addEvent('click', function(){
		var node = tree.selected;
		var id=node.id;
		
	    if(!node) return;
	    Contenedor_lab(id);
	});	
   
$('clinico_lab').addEvent('click', function(){
		var node = tree.selected;
		var id=node.id;
		
	    if(!node) return;
	    Clinicos_lab(id);
	});	   
   
  
}); 




////////////////////////////////////////////////////////////////////////////////

function tiposLab()
{
  
  var var_url = '<?=site_url()?>/atencion/aten_adm_hc/AgregarClinico'
  var ajax1 = new Request(
  {
    url: var_url,

    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_tipos_lab').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}
////////////////////////////////////////////////////////////////////////////////
function Contenedor_lab(id)
{
  
  var var_url = '<?=site_url()?>/atencion/aten_adm_hc/Agregar_cont_Clinico/'+id
  var ajax1 = new Request(
  {
    url: var_url,

    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_tipos_lab').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function Clinicos_lab(id)
{
  
  var var_url = '<?=site_url()?>/atencion/aten_adm_hc/Agregar_Clinico/'+id
  var ajax1 = new Request(
  {
    url: var_url,

    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_tipos_lab').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send();   
}




////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
function cambionombre(newName,id)
{
  var var_url = '<?=site_url()?>/atencion/aten_adm_hc/cambionombre/'+newName+'/'+id
  var ajax1 = new Request(
  {
  url: var_url,

    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_tipos_lab').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send(); 







}


////////////////////////////////////////////////////////////////////////
function confirmarordrem() {
    if(confirm('¿Esta seguro que desea remitir la orden a laboratorio?'))
	{
		return true;
	  
 }else{
 
 return false;
 }
}
///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function confirmarordenv() {
    if(confirm('¿Esta seguro que desea enviar la orden para recepcion en laboratorio?'))
	{
		return true;
	  
 }else{
 
 return false;
 }
}
///////////////////////////////////////////////////////////////////////////////
function confirmbaja() {
    if(confirm('¿La orden pasara a la lista Ordenes por Tomar?'))
	{
		return true;
	  
 }else{
 
 return false;
 }	
}
	
	

</script>    

	
	<script type="text/javascript" src="../../../resources/assets/scripts/Builder.js"></script>
   
	<script type="text/javascript">Builder.includeType('source');</script>

    
    
   
	<h1 class="tituloppal">ADMINISTRACIÓN ATENCION</h1>
    
    <table width="100%" class="tabla_form">
    <tr>


<td style="padding:0px" "width="33%" align="center" >
     <?
$data = array(  'name' => 'contenedor_lab',
		'id' => 'contenedor_lab',
        'value' => 'Nuevo Contenedor Clinicos',
		'style'=>'width:170px',
        'type' =>'button');
echo form_input($data);
?>

</td>
<td style="padding:0px" width="33%" align="center" >
 <?
$data = array(  'name' => 'clinico_lab',
		'id' => 'clinico_lab',
        'value' => 'Nuevo Dato',
		'style'=>'width:170px',
        'type' =>'button');
echo form_input($data);
?>


</td>
<td style="padding:0px" width="33%" align="center" >
    <?
$data = array(  'name' => 'rename',
		'id' => 'rename',
        'value' => 'Editar',
		'style'=>'width:170px',
        'type' =>'button');
echo form_input($data);
?>
 

</td>

</tr>
<tr>
    <td colspan="4">
    <div id="div_tipos_lab"></div>
    
    </td>
</tr> 



<tr>
    <td colspan="4">
    <div id="tree_container"></div>
    
    </td>
</tr> 

</table>