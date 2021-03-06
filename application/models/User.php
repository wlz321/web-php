<?php

class User extends CI_Model {
    public $id;
    public $username;
    public $password;
    public $nick_name;
    public $time_register;
    public $time_login;
    public $email;
    public $phone;
    public $phone_area;
    public $actived=0;

    public function __construct()
    {
        parent::__construct();
    }

    //创建新的用户
    public function create($email,$password='123456'){
        if(!isset($this->db)){
            //后期可以改成自动加载数据库设置
            $this->load->database();
        }

        $password = md5('quick_blog_'.md5($password));
        $user = new self();
        $user->password = $password;
        $user->username = 'user_'.time();
        $user->time_register = time();
        $user->email = $email;
        $this->db->insert('user',$user);
        return $user_id = $this->db->insert_id();
    }

    //查询用户
    public function find($email,$password='123456'){
        if(!isset($this->db)){
            //后期可以改成自动加载数据库设置
            $this->load->database();
        }
        $password = md5('quick_blog_'.md5($password));
        $sql = "SELECT * FROM user WHERE password = ? AND email = ?";
        $query = $this->db->query($sql, array($password , $email));
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        if(count($result) == 1){
            return $result[0];
        }
        return $result;
    }

    //判断邮箱账号是否存在
    public function exist($email){
        if(!isset($this->db)){
            //后期可以改成自动加载数据库设置
            $this->load->database();
        }
        $sql = "SELECT * FROM user WHERE email = ? limit 1";
        $query = $this->db->query($sql, array($email));
        return $query->num_rows() != 0;
    }
}