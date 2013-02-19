
<div style="width:150px; margin:10, 10, 10, 10; padding-bottom:2px"> 
  <?php 
  if ($tipo=='clinico'){
	  
  if ($tipo_dato=='numero'){
	  echo $nombre;
	 
	  echo form_input(array('name' => 'numero['.$id.']',
						'id'=> "$id",
						'autocomplete'=>'off'
						),0);
	  
	  
	  }
  if ($tipo_dato=='texto'){
	 echo $nombre;
	 echo  form_textarea(array('name' => 'texto['.$id.']',
	 'id'=> $id,
	 'autocomplete'=>'off',
	 
                                                                'rows' => '6',
                                                                'cols'=> '70'));
	  
	
	  }
  if ($tipo_dato=='lista'){
	  echo $nombre;
	   echo $this->load->view('atencion/aten_ListadoValor',$id);
	  }
  }else if($tipo=='contenedor'){
	  ?></div><div style="clear:both; border-top:solid thin; margin-top:10px"><strong style="color:#000066; font-size:16px">
  
 <?php
	  echo $nombre;
?></strong>
<?php
	 
	  echo $this->load->view('atencion/aten_ListadoValorCont',$id);
	  ?></div><?php
	  }
  
  ?>
 

  </div>