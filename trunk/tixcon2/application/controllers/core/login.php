<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('cookie');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function index()
	{
		if($this->session->userdata('nombre'))
			$this->load->view('login_true');
		else
			$this->load->view('login');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function entrar()
	{
		$this->load->database();
		$this->db->from('core_usuario');
		$this->db->where('_username',$this->input->post('user_log'));
		$consulta=$this->db->get();
		
		if($fila=$consulta->row_array())
		{
			$usu_pass = md5($this->input->post('pass_log'));
			
			if($fila['_password'] == $usu_pass)
			{
				if($fila['estado']!='activo')
				{
					echo "<script> alert('Su usuario ha sido desactivado. Comuniquese con el administrador.'); </script>\n";
				}
				else
				{
					$this->session->set_userdata('id_usuario', $fila['id_usuario']);
					$this->session->set_userdata('_username', $fila['_username']);
					$this -> session -> set_userdata('username', $fila['_username']);
					$this -> session -> set_userdata('password', $fila['_password']);
					redirect('core/home');
				}
			}
			else
			{
					$this -> load -> view('core/core_inicio');
					echo "<script> alert('Contraseña incorrecta.'); </script>\n";
					$this -> load -> view('core/pagina_inicio');
					$this -> load -> view('core/core_fin');
				
			}
		}
		else
		{
			$dat['titulo'] = "Inicio de sesi&oacute;n";
			$this -> load -> view('core/core_inicio',$dat);
			echo "<script> alert('Ha escrito su nombre de usuario incorrectamente. Vuelva a intentarlo.'); </script>\n";
			$this -> load -> view('core/pagina_inicio');
			$this -> load -> view('core/core_fin');
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function salir()
	{
		$this -> session -> sess_destroy();
		redirect('/main');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
}
