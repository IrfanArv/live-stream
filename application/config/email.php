<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'ssmtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.gmail.com', 
    'smtp_port' => 587,
    'smtp_user' => 'ir.irfan.arifin@gmail.com',
    'smtp_pass' => 'Mybigdream95',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    //'smtp_timeout' => '4', //in seconds
    'newline'    => "\r\n",
    //'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);