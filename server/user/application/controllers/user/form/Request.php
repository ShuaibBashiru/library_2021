<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Request extends CI_Controller{

function addNew(){
    try {
    $this->form_validation->set_rules('item_id', 'Item ID', 'required');
    $this->form_validation->set_rules('userid', 'user id', 'required');
    $this->form_validation->set_rules('user_request_id', 'user request id', 'required');
    $this->form_validation->set_rules('return_date', 'return date', 'required');
    if ($this->form_validation->run()==false) {
        $response=array(
            'status' => 'formerror',
            'statusmsg' => 'error',
            'error' => array($this->form_validation->error_array()),
            'msg' => 'Please provide a valid information.',
            'classname' => 'alert-danger',
        );
        echo json_encode($response);
        die();
        }else{
            $userid = $this->input->post('userid');
            $this->load->model('auth/CheckSession');
            $this->CheckSession->isSession($userid);
    $data = array(
        "userid" => $this->input->post('user_request_id'),
        "item_id" => $this->input->post('item_id'),
        "return_date" => $this->input->post('item_id'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );
  
    $param = array(
        "userid" => $this->input->post('userid'),
    );
    
$this->load->model('form/Request_Form_Model');
$this->Request_Form_Model->addNew($data, $param);

}
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