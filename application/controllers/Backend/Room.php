<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Room extends CI_Controller
{
    public $data = array();
    public $userid;
    public $role;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Room_model', '', TRUE);
        $this->load->model('QuizM', '', TRUE);
        $this->load->model('LeadM', '', TRUE);
        $this->data['isadmin'] = $this->session->userdata('logged_admin');
    }
    // view
    function index()
    {
        if ($this->data['isadmin']) {
            $this->data['pagetitle'] = 'Room Stream - Era Digital Media';
            $this->backend->display('backend/modules/room', $this->data);
        } else {
            $this->data['pagetitle'] = 'Login - Era Digital Media';
            $this->load->view('backend/auth/loginV', $this->data);
        }
    }

    public function room_list()
    {
        $list = $this->Room_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rl) {
            $id_room = $rl->id_room;
            $quiz = $this->Room_model->getQuiz($id_room);
            if ($rl->status_room == 1) {
                $status = '<a href="javascript:void(0)" onclick="roomDeactive(' . "'" . $rl->id_room . "'" . ')" class="btn btn-outline-success btn-sm rounded">Active</a>';
            } elseif ($rl->status_room == 0) {
                $status = '<a href="javascript:void(0)" onclick="roomActive(' . "'" . $rl->id_room . "'" . ')" class="btn btn-outline-danger btn-sm rounded">Deactive</a>';
            }
            $no++;
            $row = array();
            $row[] = $rl->name;
            $row[] = $rl->stream_key;
            $row[] = $status;
            $row[] = date('d M Y - H:i', strtotime($rl->updated)) . " " . "WIB";


            $row[] = '
            <td class="table-action">
                <a href="javascript:void(0)" onclick="roomEdit(' . "'" . $rl->id_room . "'" . ')" class="btn btn-icon btn-outline-success"><i class="feather icon-edit"></i></a>
            </td>
            ';
            // <a href="javascript:void(0)" onclick="deleteRoom(' . "'" . $rl->id_room . "'" . ')" class="btn btn-icon btn-outline-danger"><i class="feather icon-trash-2"></i></a>
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Room_model->count_all(),
            "recordsFiltered" => $this->Room_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function editRoom($id)
    {
        $data = $this->Room_model->get_by_id($id);
        echo json_encode($data);
    }
    // end view

    // function
    public function roomAdd()
    {
        $name               = $this->input->post('name', true);
        $stream_key         = $this->input->post('stream_key', true);
        $data = [
            'name' => $name,
            'stream_key' => $stream_key,
            'status_room' => 1,
        ];

        $result = $this->Room_model->save($data);
        echo json_encode($result);
    }

    public function roomAktif($id)
    {
        $data = [
            'status_room' => 1,
        ];

        $this->Room_model->update(array('id_room' => $id), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function roomMati($id)
    {
        $data = [
            'status_room' => 0,
        ];

        $this->Room_model->update(array('id_room' => $id), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function roomEdit()
    {

        $name               = $this->input->post('name', true);
        $stream_key         = $this->input->post('stream_key', true);
        $data = [
            'name' => $name,
            'stream_key' => $stream_key,
        ];

        $this->Room_model->update(array('id_room' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function roomDelete($id)
    {
        $this->Room_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    // quiz area

    public function quizRoom()
    {
        if ($this->data['isadmin']) {

            $this->data['pagetitle'] = "Quiz";
            $this->backend->display('backend/modules/quiz_room', $this->data);
        } else {
            $this->data['pagetitle'] = 'Login - Era Digital Media';
            $this->load->view('backend/auth/loginV', $this->data);
        }
    }

    public function leader_board()
    {
        if ($this->data['isadmin']) {

            $this->data['pagetitle'] = "Leaderboard";
            $this->backend->display('backend/modules/leaderboardV', $this->data);
        } else {
            $this->data['pagetitle'] = 'Login - Era Digital Media';
            $this->load->view('backend/auth/loginV', $this->data);
        }
    }

    public function quiz_list()
    {
        $list = $this->QuizM->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rl) {
            if ($rl->status == 1) {
                $status = '<a href="javascript:void(0)" class="btn btn-outline-success btn-sm rounded">Active</a>';
            } elseif ($rl->status == 0) {
                $status = '<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm rounded">Deactive</a>';
            }
            if ($rl->image ==!null){
                $gambar = "
                <td class='align-middle'>
                <img src='../../../assets/img/games/trivia/$rl->image'  class='mr-3' style='height:120px;width:120px;'/>
                <p class='m-0 d-inline-block align-middle font-16'>
                $rl->title
                </p>
                </td>";
            }else{
                $gambar = "$rl->title";
            }
            $no++;
            $row = array();
            $row[] = $gambar;
            $row[] = $rl->poin;
            // $row[] = $rl->time. " Detik";
            $row[] = $status;
            $row[] = date('d M Y - H:i', strtotime($rl->updated_at)) . " " . "WIB";
            $row[] = '
            <td class="table-action">
                <a href="javascript:void(0)" onclick="quizEdit(' . "'" . $rl->id . "'" . ')" class="btn btn-icon btn-outline-success"><i class="feather icon-edit"></i></a>
                <a href="javascript:void(0)" onclick="deleteQuiz(' . "'" . $rl->id . "'" . ')" class="btn btn-icon btn-outline-danger"><i class="feather icon-trash-2"></i></a>
            </td>
            ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Room_model->count_all(),
            "recordsFiltered" => $this->Room_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function lead_list()
    {
        $list = $this->LeadM->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rl) {
            $no++;
            $row = array();
            $row[] = $rl->full_name;
            $row[] = $rl->branch_user;
            $row[] = $rl->phone;
            $row[] = $rl->game_1_score;
            $row[] = date('d M Y - H:i', strtotime($rl->modified)) . " " . "WIB";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->LeadM->count_all(),
            "recordsFiltered" => $this->LeadM->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    // end function

}
