<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class Request_Update_Model extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}

function update($data, $param){
    try{
    $this->db->where('id', $param['request_id'])
                ->update('item_request_tbl', $data);
    if ($this->db->affected_rows() > 0) {
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'The status has been updated successfully',
            'classname' => 'alert-primary',
            'result' => '',  
            'redirect' => '',
        );
        echo json_encode($response);
        die();
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating this record, please try again later or report this error.',
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