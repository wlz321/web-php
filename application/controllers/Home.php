<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends QB_Controller{
	public function index(){
		$this->render('common/header');
    $this->render('common/footer');
	}

	public function dbtest(){
		$this->load->database();
		var_dump($this->db) ;
	}
  public function insert(){
      $this->load->model('User');
      $email = '2505013465@qq.com';
      $result = $this->User->create($email);
      var_dump($result);
  }
}
