<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Dashboard';
$route['404_override'] = 'home/error';
// dashboard
$route['dashboard'] = 'Dashboard';
$route['dashboard/login'] = 'Dashboard/login';
$route['dashboard/logout'] = 'Dashboard/logout';
// jalan quiz
$route['dashboard/jalan_quiz'] = 'Dashboard/kirim_quiz';
$route['dashboard/stop_quiz'] = 'Dashboard/stop_quiz';
$route['dashboard/reset_quiz'] = 'Dashboard/reset_quiz';

$route['dashboard/settings'] = 'Dashboard/settings';
$route['dashboard/setting_update'] = 'Dashboard/update_commons';

// vote
$route['dashboard/jalan_vote'] = 'Dashboard/kirim_vote';
$route['dashboard/stop_vote'] = 'Dashboard/stop_vote';


// dashboard
$route['dashboard/stream-room'] = 'Backend/Room';
$route['dashboard/room_list'] = 'Backend/Room/room_list';
$route['dashboard/room_add'] = 'Backend/Room/roomAdd';
$route['dashboard/room_edit/(:any)'] = 'Backend/Room/editRoom/$1';
$route['dashboard/room_page'] = 'Backend/Room/roomEdit/';
$route['dashboard/room_delete/(:any)'] = 'Backend/Room/roomDelete/$1';
$route['dashboard/room_aktif/(:any)'] = 'Backend/Room/roomAktif/$1';
$route['dashboard/room_mati/(:any)'] = 'Backend/Room/roomMati/$1';

$route['dashboard/quiz'] = 'Backend/Room/quizRoom';
$route['dashboard/quiz_list'] = 'Backend/Room/quiz_list';


$route['dashboard/leader-board'] = 'Backend/Room/leader_board';
$route['dashboard/lead_list'] = 'Backend/Room/lead_list';

// cek quiz
$route['cek_quiz'] = 'Main/quizCek';
$route['end_quiz'] = 'Main/end_quiz';
$route['check_answer'] = 'Main/check_answer';
$route['get_score'] = 'Main/get_score';
// API
$route['api/request-token'] = 'Api/req_token';
// room
$route['room'] = 'Main/room_stream';

// vote
$route['save_vote'] = 'Main/save_vote';
$route['get_vote'] = 'Main/get_vote';
$route['end_vote'] = 'Main/end_vote';
$route['cek_voting'] = 'Main/cek_voting';
