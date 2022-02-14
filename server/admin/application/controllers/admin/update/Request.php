<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Request extends CI_Controller{


function status(){
    try {
    // $userid = $this->input->get('userid');
    // $this->load->model('auth/CheckSession');
    // $this->CheckSession->isSession($userid);
    $data = array(
        "status_id" => $this->input->get('status_id'),
    );
  
    $param = array(
        "request_id" => $this->input->get('request_id'),
    );
    
$this->load->model('update/Request_Update_Model');
$this->Request_Update_Model->update($data, $param);

} catch (Exception $e) {
    $response=array( 
        'status' => 'errorform',
        'statusmsg' => 'error',
        'error' => array($e->getMessage()),
        'msg' => 'Server error, kindly try again or report this error.',
        'classname' => 'alert-danger',
    );
    echo json_encode($response);
    die();
}
}
}