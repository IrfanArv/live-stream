<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public $data = array();
    public $userid;
    public $role;

    function __construct()
    {
        parent::__construct();
        $this->data['isadmin'] = $this->session->userdata('logged_admin');
        $this->data['isSuperAdmin'] = $this->session->userdata('logged_super_admin');
        $this->userid = $this->session->userdata('logged_id');
        $this->data['accType'] = $this->session->userdata('accountType');
        $this->role = $this->session->userdata('role');
        $this->data['role'] = $this->role;
        $this->data['userloggedin'] = $this->session->userdata('logged_admin');
        $this->load->model('VisitorsM');
        $this->load->model('question_model', '', TRUE);
        $this->load->model('question_answer_model', '', TRUE);
        $this->load->library('session');
    }

    function index()
    {

        if ($this->validadmin()) {
            $common_quiz	= $this->FrontM->common_quiz();
            $statusQuiz     = $this->FrontM->cekQuiz();
            $this->data['total_quiz'] = $this->FrontM->getQuiz();
            $this->data['quiz_time'] = $common_quiz->quiz_time;
            $this->data['vote_time'] = $common_quiz->vote_time;
            $this->data['quiz_time_general'] = $common_quiz->end_time_quiz;
            $this->data['vote_time_general'] = $common_quiz->end_time_vote;
            $this->data['status_quiz'] = $statusQuiz;

            // vote
            $status_vote = $common_quiz->vote_status;
            if ($status_vote == 1){
                $this->data['title_vote'] = "<h6 class='m-b-10 m-t-10'>Berlangsung</h6>";
                $this->data['button_vote'] = "<button class='btn btn-primary btn-block' disabled>Voting sedang berlangsung</button>";
            }elseif($status_vote == 0){
                $this->data['title_vote'] = "<h6 class='m-b-10 m-t-10'>Menunggu</h6>";
                $this->data['button_vote'] = "<button class='btn btn-success btn-block' onclick='vote_jalan()'>Mulai Sesi Voting</button>";
            }else{
                $this->data['title_vote'] = "<h6 class='m-b-10 m-t-10'>Selesai</h6>";
                $this->data['button_vote'] = "<button class='btn btn-danger btn-block' disabled>Voting sudah dilaksanakan</button>";
            }
            // quiz sedang berjalan
            if ($statusQuiz == 1) {
                $this->data['title_quiz'] = "<h6 class='m-b-10 m-t-10'>Berlangsung</h6>";
                $this->data['button_quiz'] = "<button class='btn btn-primary btn-block' disabled>Quiz sedang berlangsung</button>";
                // menunggu
            } else if ($statusQuiz == 0) {
                $this->data['title_quiz'] = "<h6 class='m-b-10 m-t-10'>Menunggu</h6>";
                $this->data['button_quiz'] = "<button class='btn btn-success btn-block' onclick='quiz_jalan()'>Jalankan Quiz</button>";
                // selesai
            } else {
                $this->data['title_quiz'] = "<h6 class='m-b-10 m-t-10 text-danger'>Selesai</h6>";
                $this->data['button_quiz'] = "<button class='btn btn-danger btn-block' disabled>Quiz telah selesai</button>";
            }
            $this->data['pagetitle'] = 'Dashboard - Era Digital Media';
            $this->backend->display('backend/modules/dashboardV', $this->data);
        } else {
            $this->data['pagetitle'] = 'Login - Era Digital Media';
            $this->load->view('backend/auth/loginV', $this->data);
        }
    }

    function reset_quiz()
    {
        $this->db->truncate('question_answers');
        $data = [
            'quiz_status'      => 0,
            'vote_status'      => 0,
            'start_time_quiz'      => NULL,
            'end_time_quiz'      => NULL,
            'start_time_vote'      => NULL,
            'end_time_vote'      => NULL,
        ];
        $data2 = [
            'game_1_status'      => 0,
            'game_1_score'      => 0,
            'voted'      => NULL,
        ];
        $this->FrontM->jalanQuiz(array('id' => 1), $data);
        $this->FrontM->resetUserGame(array('id' => 1), $data2);
        echo json_encode(array("status" => TRUE));
    }

    function kirim_quiz()
    {

        $get_time_quiz  = $this->FrontM->common_quiz();
        $quiz_time      = $get_time_quiz->quiz_time;
        $date_start     = date('Y-m-d H:i:s');
        $date_end       = date('Y-m-d H:i:s', strtotime("+$quiz_time min"));

        $status                = 1;
        $data = [
            'quiz_status'        => $status,
            'start_time_quiz'    => $date_start,
            'end_time_quiz'      => $date_end,
        ];
        $this->FrontM->jalanQuiz(array('id' => 1), $data);


        require_once(APPPATH . '../vendor/autoload.php');
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '579d64e9c5fbacc17651',
            '5b349e026d5bce546e7f',
            '1407293',
            $options
        );
        $data['message'] = 'push_quiz';
        $trivia_id = 1;
        $question =  $this->question_model->get_first_question($trivia_id);
        $question_detail = $this->question_model->get_detail($question->id);
        $statusQuiz     = $this->FrontM->cekQuiz();
        $data['status_quiz'] = $statusQuiz;
        $data['trivia_id'] = $trivia_id;
        $data['content_view'] = "question.php";
        $data['question'] = $question;
        $data['question_detail'] = $question_detail;
        $data['quiz_time_general'] = $date_end;
        $data['getView'] = $this->load->view(GAME_LAYOUT, $data, TRUE);
        $pusher->trigger('my-channel', 'my-event', $data);
        echo json_encode(array(
            "status" => TRUE,
            "waktu_quiz" => $date_end,
        ));
    }

    function stop_quiz()
    {
        $data = [
            'quiz_status'      => 2
        ];
        $this->FrontM->jalanQuiz(array('id' => 1), $data);
        echo json_encode(array("status" => TRUE));
    }

    function login()
    {

        $username = $this->input->post('email');
        $password = $this->input->post('password');
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {

                $result = array("status" => false, "msg" => validation_errors(), "url" => "");
            } else {

                $login = $this->Accounts_model->login_admin($username, $password);
                if ($login) {
                    $prevurl = $this->session->userdata('prevURL');
                    if (!empty($prevurl)) {
                        $url = $prevurl;
                    } else {
                        $url = base_url() . 'dashboard';
                    }

                    $result = array("status" => true, "msg" => "", "url" => $url);
                } else {
                    $result = array("status" => false, "msg" => "Invalid Login Credentials", "url" => "");
                }
            }
            echo json_encode($result);
        }
    }

    function validadmin()
    {

        if (!empty($this->data['isadmin'])) {
            return true;
        } else {
            return false;
        }
    }

    function logout()
    {
        $lastlogin = $this->session->userdata('logged_time');
        $updatelogin = array('accounts_last_login' => $lastlogin);
        $this->db->where('accounts_id', $this->userid);
        $this->db->update('accounts', $updatelogin);
        $this->session->sess_destroy();
        redirect('dashboard');
    }

    function settings()
    {
        $settings  = $this->FrontM->common_quiz();
        $status_quiz = $settings->quiz_status;
        $status_vote = $settings->vote_status;
        if($status_quiz == 0){
            $quiz_status = "Menunggu";
        }elseif($status_quiz == 1){
            $quiz_status = "Sedang Belangsung";
        }else{
            $quiz_status = "Selesai";
        }
        if($status_vote == 0){
            $vote_status = "Menunggu";
        }elseif($status_vote == 1){
            $vote_status = "Sedang Belangsung";
        }else{
            $vote_status = "Selesai";
        }

        if($settings->start_time_quiz == NULL){
            $waktu_quiz_mulai = "Belum Tersedia";
        }else{
            $waktu_quiz_mulai =  date('d M Y - H:i', strtotime($settings->start_time_quiz)) . " " . "WIB";
        }

        if($settings->end_time_quiz == NULL){
            $waktu_quiz_selesai = "Belum Tersedia";
        }else{
            $waktu_quiz_selesai =  date('d M Y - H:i', strtotime($settings->end_time_quiz)) . " " . "WIB";
        }


        if($settings->start_time_vote == NULL){
            $waktu_vote_mulai = "Belum Tersedia";
        }else{
            $waktu_vote_mulai =  date('d M Y - H:i', strtotime($settings->start_time_vote)) . " " . "WIB";
        }

        if($settings->end_time_vote == NULL){
            $waktu_vote_selesai = "Belum Tersedia";
        }else{
            $waktu_vote_selesai =  date('d M Y - H:i', strtotime($settings->end_time_vote)) . " " . "WIB";
        }

        if ($this->data['isadmin']) {
            $this->data['pagetitle'] = 'Settings';
            $this->data['quiz_time'] = $settings->quiz_time;
            $this->data['started_quiz'] = $waktu_quiz_mulai;
            $this->data['ended_quiz'] = $waktu_quiz_selesai;
            $this->data['quiz_status'] = $quiz_status;
            // vote
            $this->data['vote_time'] = $settings->vote_time;
            $this->data['started_vote'] = $waktu_vote_mulai;
            $this->data['ended_vote'] = $waktu_vote_selesai;
            $this->data['vote_status'] = $vote_status;
            $this->backend->display('backend/modules/settingV', $this->data);
        } else {
            $this->data['pagetitle'] = 'Login';
            $this->load->view('backend/auth/loginV', $this->data);
        }
    }

    function update_commons()
    {
        $quiz_time  = $this->input->post('quiz_time', true);
        $vote_time  = $this->input->post('vote_time', true);
        $data = [
            'quiz_time'     => $quiz_time,
            'vote_time'     => $vote_time,
        ];

        $this->FrontM->update_common(array('id' => 1), $data);
        echo $this->session->set_flashdata('msg','sukses');
        redirect('dashboard/settings');
    }

    function kirim_vote()
    {

        $get_time_vote  = $this->FrontM->common_quiz();
        $vote_time      = $get_time_vote->vote_time;
        $date_start     = date('Y-m-d H:i:s');
        $date_end       = date('Y-m-d H:i:s', strtotime("+$vote_time min"));

        $status                = 1;
        $data = [
            'vote_status'        => $status,
            'start_time_vote'    => $date_start,
            'end_time_vote'      => $date_end,
        ];
        $this->FrontM->jalanQuiz(array('id' => 1), $data);


        require_once(APPPATH . '../vendor/autoload.php');
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '579d64e9c5fbacc17651',
            '5b349e026d5bce546e7f',
            '1407293',
            $options
        );
        $data['message'] = 'push_vote';
        $data['content_view'] = "vote.php";
        $data['end_time_vote'] = $date_end;
        $data['getView'] = $this->load->view(GAME_LAYOUT, $data, TRUE);
        $pusher->trigger('vote-chanel', 'vote-event', $data);
        echo json_encode(array(
            "status" => TRUE,
            "waktu_vote" => $date_end,
        ));
    }


}
