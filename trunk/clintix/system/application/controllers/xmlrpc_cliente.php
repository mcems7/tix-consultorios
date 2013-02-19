

<?php
class Xmlrpc_cliente extends Controller {
function index()
{
$this->load->helper('url');
$this->load->library('xmlrpc');
$server_url = site_url('xmlrpc_server');
$this->load->library('xmlrpc');  


$this->xmlrpc->server($server_url, 80);
$this->xmlrpc->method('Greetings');
$request = array (
array('pirulo', 'string'),
array('pirulo_pass', 'string'),
);
$this->xmlrpc->request($request);
	//$this->xmlrpc->set_debug(TRUE);
if ( ! $this->xmlrpc->send_request())
{
echo $this->xmlrpc->display_error();

}
else
{
echo '<pre>';
print_r($this->xmlrpc->display_response());
echo '</pre>';
}
}
}
?>
