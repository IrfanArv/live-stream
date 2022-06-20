<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Link extends CI_Controller
{
    public $data = array();
    public $userid;
    public $role;

    function __construct()
    {
        parent::__construct();
        $this->data['isadmin'] = $this->session->userdata('logged_admin');
    }
    // view
    function index()
    {
        if ($this->data['isadmin']) {
            $this->data['pagetitle'] = 'Webly Link - Webly';
            $this->backend->display('backend/modules/linkV', $this->data);
        } else {
            $this->data['pagetitle'] = 'Login - Webly';
            $this->load->view('backend/auth/loginV', $this->data);
        }
    }

    public function linkList()
    {
        $list = $this->LinkM->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rl) {
            if ($rl->status == 1) {
                $status = "<span class='badge badge-success'>Active</span>";
            } elseif ($rl->status == 0) {
                $status = "<span class='badge badge-danger'>Deactive</span>";
            }
            $no++;
            $row = array();
            $row[] = $rl->name;
            $row[] = $rl->uri;
            $row[] = $status;
            $row[] = date('d M Y - H:i', strtotime($rl->updated)) . " " . "WIB";


            $row[] = '
            <td class="table-action">
                <a href="javascript:void(0)" onclick="linkEdit(' . "'" . $rl->id . "'" . ')" class="btn btn-icon btn-outline-success"><i class="feather icon-edit"></i></a>
                <a href="javascript:void(0)" onclick="deleteLink(' . "'" . $rl->id . "'" . ')" class="btn btn-icon btn-outline-danger"><i class="feather icon-trash-2"></i></a>
            </td>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->LinkM->count_all(),
            "recordsFiltered" => $this->LinkM->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function editLink($id)
    {
        $data = $this->LinkM->get_by_id($id);
        echo json_encode($data);
    }
    // end view

    // function
    public function linkAdd()
    {
        $name               = $this->input->post('name', true);
        $uri                = $this->input->post('uri', true);
        $status             = $this->input->post('status');
        $data = [
            'name' => $name,
            'uri' => $uri,
            'status' => $status,
        ];

        $result = $this->LinkM->save($data);
        echo json_encode($result);
    }

    public function linkEdit()
    {
 
        $name               = $this->input->post('name', true);
        $uri                = $this->input->post('uri', true);
        $status             = $this->input->post('status');
        $data = [
            'name'      => $name,
            'uri'       => $uri,
            'status'    => $status,
        ];

        $this->LinkM->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function linkDelete($id)
    {
        $this->LinkM->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


    // end function

}
