
<div style="float:left; width:150px; margin:10, 10, 10, 10; padding-bottom:20px"> 

  	
   

  <?php 
  if ($tipo=='clinico'){
	  
  if ($tipo_dato=='numero'){
	  echo $nombre;
	 
	  echo form_input(array('name' => 'numero['.$id.']',
						'id'=> "$id",
						'autocomplete'=>'off',
						'class'=>"fValidate['integer']"));
	  
	  
	  }
  if ($tipo_dato=='texto'){
	  echo $nombre;
	 echo  form_textarea(array('name' => 'texto['.$id.']',
	 'id'=> $id,
	 'autocomplete'=>'off',
	 'class'=>"fValidate['required']",
                                                                'rows' => '3',
                                                                'cols'=> '15'));
	  
	
	  }
  if ($tipo_dato=='lista'){
	  echo $nombre;
	   echo $this->load->view('lab/lab_ListadoValor',$id);
	  }
  }else if($tipo=='contenedor'){
	  ?></div><div style="clear:both; border-top:solid thin; margin-top:50px"><strong style="color:#000066; font-size:16px">
  
 <?php
	  echo $nombre;
?></strong>
<?php
	 
	  echo $this->load->view('lab/lab_ListadoValorCont',$id);
	  ?></div><?php
	  }
  
  ?>
 

  </div>