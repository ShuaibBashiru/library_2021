<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Request extends CI_Controller{

function itemlist(){
    $data = array(
        "fetch" => 1,
        "status" => 1,
        "displayNumber" => $this->input->get('limitTo'),
        "userid" => $this->input->get('userid'),
        "user_request_id" => $this->input->get('user_request_id'),
    );
$this->load->model('api/Request_Api_Model');
$this->Request_Api_Model->getItems($data);
}

}