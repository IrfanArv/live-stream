<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->VisitorsM->count_visitor();
		$this->load->model('question_model', '', TRUE);
		$this->load->model('question_answer_model', '', TRUE);
		$this->load->library('session');
	}

	public function room_stream()
	{
		// $this->session->set_userdata('is_user', 7493);
		// matiin ini kalo udah selesai
		$id_user 		= @$this->session->is_user;
		if ($id_user) {
			$data_user 		= $this->FrontM->getUser($id_user);
			if ($data_user == NULL) {
				$this->load->view('frontend/modules/reload_page');
			} else {
				$room_user		= $data_user->branch_user;
				$get_stream		= $this->FrontM->getRoomStream($room_user);
				if ($get_stream == NULL) {
					$data_stream  = FALSE;
				} else {
					$data_stream = $get_stream->stream_key;
					$room_name 	= $get_stream->name;
				}
				// banner
				if ($room_user == "Jakarta" || $room_user == "Serang" || $room_user == "Bogor"){
					$banner = "area1.jpg";
				} elseif ($room_user == "Yogyakarta" || $room_user == "Bandung" || $room_user == "Semarang" || $room_user == "Purwokerto" || $room_user == "Cirebon") {
					$banner = "area2.jpg";
				}elseif ($room_user == "Kediri" || $room_user == "Denpasar" || $room_user == "Surabaya"){
					$banner = "area3.jpg";
				}elseif ($room_user == "Jambi" || $room_user == "Palembang" || $room_user == "Lampung"){
					$banner = "area4.jpg";
				}elseif ($room_user == "Medan" || $room_user == "Pekanbaru" || $room_user == "Padang"){
					$banner = "area5.jpg";
				}elseif ($room_user == "Banjarmasin" || $room_user == "Samarinda" || $room_user == "Pontianak"){
					$banner = "area6.jpg";
				}elseif ($room_user == "Makasar" || $room_user == "Kendari" || $room_user == "Manado" || $room_user == "Palu"){
					$banner = "area7.jpg";
				}
				$data 			= array(
					'banner'		=> $banner,
					'data_stream'	=> $data_stream,
					'room_stream'	=> $room_name,
					'full_name'		=> $data_user->full_name,
				);
				$this->load->view('frontend/modules/mainV', $data);
			}
		} else {
			redirect('api/request-token');
		}
	}


	public function quizCek()
	{
		$trivia_id 		= 1;
		$passkey 		= @$this->session->is_user;
		$user 			= $this->AuthM->get_account_by_id($passkey);
		$user_id 		= $user->id;
		$waktu_quiz		= $this->FrontM->common_quiz();

		// Cek last question
		$last_question = $this->question_answer_model->get_last_question($user_id, $trivia_id);
		if ($last_question == NULL) {
			$question =  $this->question_model->get_first_question($trivia_id);
		} else {
			$question =  $this->question_model->get_next_question($trivia_id, $last_question->question_id);
		}
		$total_success = $this->question_answer_model->get_total_success($user_id, $trivia_id);

		$statusQuiz     = $this->FrontM->cekQuiz();
		// Jika semua pertanyaan sudah abis
		$pertanyaan_habis = 0;
		$getView = 0;
		if ($question == NULL) {
			$game_status = 1;
			$data_user = array("game_1_status" => $game_status, "game_1_score" => $total_success);
			$this->AuthM->updateGameAccount("id = $user_id", $data_user);
			// pertanyaan habis
			$pertanyaan_habis = 1;
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
				$data['message'] = 'push_lead';
				$pusher->trigger('channel-lead', 'event-lead', $data);
		} else {
			$question_detail = $this->question_model->get_detail($question->id);
			$common_quiz	 = $this->FrontM->common_quiz();

			// initial data view
			$data['status_quiz'] = $statusQuiz;
			$data['quiz_time_general'] = $common_quiz->end_time_quiz;
			$data['trivia_id'] = $trivia_id;
			$data['content_view'] = "question.php";
			$data['question'] = $question;
			$data['question_detail'] = $question_detail;
			$data['time'] = $waktu_quiz->quiz_time;
			$getView = $this->load->view(GAME_LAYOUT, $data, TRUE);

		}
		$user_status = $user->game_1_status;
		echo json_encode(array(
			"pertanyaan_habis" 		=> $pertanyaan_habis,
			"status" 				=> $statusQuiz,
			"loadView" 				=> $getView,
			"userStatus" 			=> $user_status,
		));
	}



	public function end_quiz()
	{
		$user_id 				= @$this->session->is_user;
		$status             	= 2;
		$data = [
			'quiz_status'      => $status,
		];
		$this->FrontM->jalanQuiz(array('id' => 1), $data);
		$game_status = 1;
		$data_user = array("game_1_status" => $game_status, "game_1_score" => 0);
		$this->AuthM->updateGameAccount("user_id = $user_id", $data_user);
	}

	public function end_vote()
	{
		$user_id 				= @$this->session->is_user;
		$status             	= 2;
		$data = [
			'vote_status'      => $status,
		];
		$this->FrontM->jalanQuiz(array('id' => 1), $data);
	}

	public function check_answer()
	{
		// Validate and get user
		$passkey = @$this->session->is_user;
		$user = $this->AuthM->get_account_by_id($passkey);
		$user_id = $user->id;
		// Get request data
		$qid = $this->input->post('qid');
		$answer = $this->input->post('answer');
		$trivia_id = $this->input->post('trivia_id');

		// Check status
		if ($answer != 0)
			$is_correct = $this->question_model->check_answer($answer);
		else
			$is_correct = 0;

		if ($is_correct == 0){
			$point = 5;
		}else{
			$point = 15;
		}

		// Set data
		$data = array(
			"user_id" => $user_id,
			"trivia_id" => $trivia_id,
			"question_id" => $qid,
			"answer" => $answer,
			"status" => $is_correct,
			"point_total" => $point,
			"created_at" => date("Y-m-d H:i:s")
		);
		// Save question answer
		$this->question_answer_model->save($data, '');

		// Return status
		echo $is_correct;
	}

	function get_score()
	{
		$data = $this->FrontM->get_score();
		echo json_encode($data);
	}

	public function save_vote()
	{
		// Validate and get user
		$passkey = @$this->session->is_user;
		$user = $this->AuthM->get_account_by_id($passkey);
		$user_id = $user->id;
		// Get request data
		$vote = $this->input->post('vote');

		$user_id 				= @$this->session->is_user;
		$data = [
			'voted'      => $vote,
		];

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
		$pusher->trigger('channel-vote', 'event-vote', $data);
		$this->FrontM->resetUserGame(array('user_id' => $user_id), $data);
	}

	public function cek_voting(){
		$common = $this->FrontM->common_quiz();
		$status_vote = $common->vote_status;
		$date_end = $common->end_time_vote;
		$passkey 		= @$this->session->is_user;
		$user 			= $this->AuthM->get_account_by_id($passkey);
		$user_status = $user->voted;
		if ($status_vote == 1){
			$data['content_view'] = "vote.php";
			$data['end_time_vote'] = $date_end;
			$getViewVote = $this->load->view(GAME_LAYOUT, $data, TRUE);
		}else{
			$getViewVote = 0;
		}
		echo json_encode(array(
			"status_vote" 			=> $status_vote,
			"loadView" 				=> $getViewVote,
			"user_vote" 			=> $user_status,
		));


	}

	public function get_vote(){
		$data = $this->FrontM->get_semua_vote();
		echo json_encode($data);
	}
}
