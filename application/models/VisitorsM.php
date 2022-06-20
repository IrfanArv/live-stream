<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class VisitorsM extends CI_Model{

	function set_pengunjung($user_ip){
		$hsl=$this->db->query("INSERT INTO visitors (pengunjung_ip) VALUES ('$user_ip')");
		return $hsl;
	}

	function statistik_pengujung(){
        $query = $this->db->query("SELECT DATE_FORMAT(pengunjung_tanggal,'%d') AS tgl,COUNT(pengunjung_ip) AS jumlah FROM visitors WHERE MONTH(pengunjung_tanggal)=MONTH(CURDATE()) GROUP BY DATE(pengunjung_tanggal)");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function simpan_user_agent($user_ip,$agent){
    	$hsl=$this->db->query("INSERT INTO visitors (pengunjung_ip,pengunjung_perangkat) VALUES('$user_ip','$agent')");
    	return $hsl;
    }

    function cek_ip($user_ip){
    	$hsl=$this->db->query("SELECT * FROM visitors WHERE pengunjung_ip='$user_ip' AND DATE(pengunjung_tanggal)=CURDATE()");
    	return $hsl;
    }

    function count_visitor(){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot(); 
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent='Other';
        }
        $cek_ip=$this->db->query("SELECT * FROM visitors WHERE pengunjung_ip='$user_ip' AND DATE(pengunjung_tanggal)=CURDATE()");
        if($cek_ip->num_rows() <= 0){
            $hsl=$this->db->query("INSERT INTO visitors (pengunjung_ip,pengunjung_perangkat) VALUES('$user_ip','$agent')");
            return $hsl;
        }
    }


    function count_visitor_link($link_id){
        $user_ip=$_SERVER['REMOTE_ADDR'];
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot(); 
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent='Other';
        }
        $cek_ip=$this->db->query("SELECT * FROM visitor_links WHERE pengunjung_ip='$user_ip' AND DATE(pengunjung_tanggal)=CURDATE() AND pengunjung_link_id='$link_id'");
        if($cek_ip->num_rows() <= 0){
            $hsl=$this->db->query("INSERT INTO visitor_links (pengunjung_ip,pengunjung_perangkat,pengunjung_link_id) VALUES('$user_ip','$agent','$link_id')");
            return $hsl;
        }
    }

    function visitor_month(){
        $query=$this->db->query("SELECT * FROM visitors WHERE DATE_FORMAT(pengunjung_tanggal,'%m%y')=DATE_FORMAT(CURDATE(),'%m%y')");
        return $query->num_rows();
    }

    function visitor_last(){
        $query=$this->db->query("SELECT * FROM visitors WHERE DATE_FORMAT(pengunjung_tanggal,'%m%y')=DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH),'%m%y')");
        return $query->num_rows();
    }

    function total_visits(){
        $query=$this->db->query("SELECT * FROM visitors WHERE DATE_FORMAT(pengunjung_tanggal,'%y')=DATE_FORMAT(CURDATE(),'%y')");
        return $query->num_rows();
    }


    function browser(){
        $query = $this->db->query("SELECT pengunjung_perangkat AS browser,COUNT(pengunjung_perangkat) AS jml FROM visitors GROUP BY pengunjung_perangkat");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}