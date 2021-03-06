<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use OSS\OssClient;
use OSS\Core\OssException;

class Rest{
  public function restResult($reason='ok',$data=array(),$code=0){
    header("Content-Type:application/json;charset=utf-8");
    if(is_array($reason)){
      $data=$reason;
      $reason='ok';
    }
    if(!is_array($data)){
      $data = array($data);
    }
    $result = array(
      'reason'=>$reason,
      'code'=>$code,
      'data'=>$data
    );
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    die($result);
  }
  public function index(){
    phpinfo();
    die;
    $accessKeyId = 'your_access_key_id';
    $accessKeySecret = 'your_access_key_secret';
    $endpoint = 'https://oss-cn-hangzhou.aliyuncs.com';
    $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    var_dump($ossClient);
    die;
    $this->restResult('index');
	}

  public function getUploadId(){
    $user_key = isset($_POST['user_id']) ? $_POST['user_id'] : 'whoami';
    $upload_id = md5( $user_key . time() );
    //todo 记录一条upload_id 到数据库
    $this->restResult(['upload_id'=>$upload_id]);
	}
	public function upload2OSS(){
    
    //1、处理上传的分片文件
    if(!isset($_FILES['blob']) || !isset($_POST['upload_id'])){
      $this->restResult('Less Param blob or upload_id',[],500);
    }
    //1.2、todo 先判断是否有upload_id
    $upload_id = $_POST['upload_id'] ;

    //上传buffer中
    $file = $_FILES['blob'];
    $file_md5 = md5_file($file['tmp_name']);
    $file_index = $_POST['file_index'] ;
    $this->restResult(['file_md5'=>$file_md5]);
	}
  //校验文件完整性，完成上传
  public function verifyUpload(){
    //判断upload_id 是否存在
    $upload_id = $_POST['upload_id'] ;
    $file_count = isset($_POST['file_count']) ? intval($_POST['file_count']) : null ;
    $this->restResult('verifyUpload');
  }
  
}
