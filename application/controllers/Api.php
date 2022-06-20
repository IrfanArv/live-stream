<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
/**
 * @package  : API
 */
class Api extends CI_Controller
{

    public function __construct()
    {

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct();
        $this->load->library('user_agent');
        $this->config->set_item('csrf_protection', TRUE);
        $this->load->library('session');
    }

    public function req_token()
    {

        header('Access-Control-Allow-Origin: *');
        $token = $this->input->get_request_header('Authorization');
        if (!$token) {
            $this->load->view('frontend/modules/reload_page');
        } else {
            $url = 'https://sharp-event.suitdev.com/api/profile';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type:application/json',
                'Authorization:Bearer '.$token.''
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $data = (array)json_decode($result, true);
            $status        = $data['status'];
            if ($status == 401){
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $id_user       = $data['data']['user']['id'];
                $token_user    = $token;
                $room          = $data['data']['user']['room'];
                $branch        = $data['data']['user']['branch'];
                $ip            = $this->input->ip_address();
                $user_name     = $data['data']['user']['username'];
                $name          = $data['data']['user']['name'];
                $email         = $data['data']['user']['email'];
                $phone         = $data['data']['user']['phone'];
                $data = array(
                    'token'             => $token_user,
                    'user_id'           => $id_user,
                    'room'              => $room,
                    'branch_user'       => $branch,
                    'ip_address'        => $ip,
                    'user_name'         => $user_name,
                    'full_name'         => $name,
                    'email'             => $email,
                    'phone'             => $phone
                );
                $get_user = $this->FrontM->getUser($id_user);
                $cek_user = $get_user->user_id;
                if (!$cek_user) {
                    $this->FrontM->signup($data);
                } else {
                    $this->FrontM->update_user(array('user_id' => $id_user), $data);
                }
                $this->session->set_userdata('is_user', $id_user);
                return redirect(base_url('room'));
            }

        }
    }
}
