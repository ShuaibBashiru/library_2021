<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class Request_Api_Model extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getItems($data){
    try{
    $sql = "SELECT t1.*, t2.title, t2.contents FROM item_request_tbl t1 INNER JOIN items_tbl t2 ON t2.id=t1.item_id WHERE t1.userid=?";
    $res = $this->db->query($sql, array($data['user_request_id']));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        $response=array(
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'Successfull',
            'classname' => 'alert-primary',
            'result' => $rows,  
        );
        echo json_encode($response);
        die();
    }else{
        $error = $this->db->error();
        $response=array(
            'status' => 'error processing',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'msg' => '',
            'result' => $error['message'],
            'error' => '',
        );
        echo json_encode($response);
        die();
} 
    } catch (Exception $e) {
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'msg' => 'Server error, kindly try again or report this error.',
            'classname' => 'alert-danger',
            'error' => $e->getMessage(),
        );
        echo json_encode($response);
        die();
    }

}


}