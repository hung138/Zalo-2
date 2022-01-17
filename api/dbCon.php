<?php

function connectt() {
    $h = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'zalochat';
 
    $conn = mysqli_connect('localhost', 'root', '', 'zalochat');
    if(!$conn){
        Respone(1001, []);
        die();
    } else {
        mysqli_set_charset($conn, "utf8");
        return $conn;
    }
    
};

function Respone($code, $data){
    $mess = '';
    $res = [];
    switch ($code) {
    case 1000:
        $mess = "OK";
        break;
    case 9992:
        $mess = "Post is not existed";
        break;
    case 9993:
        $mess = "Code verify is incorrect";
        break;
    case 9994:
        $mess = "No data or end of list data";
        break;
    case 9995:
        $mess = "User is not validated";
        break;
    case 9996:
        $mess = "User is existed";
        break;
    case 9997:
        $mess = "Method is invalid";
        break;
    case 9998:
        $mess = "Token is invalid";
        break;
    case 9999:
        $mess = "Exception error";
        break;
    case 1001:
        $mess = "Cannot connect to DB";
        break;
    case 1002:
        $mess = "Parameter is not enought";
        break;
    case 1003:
        $mess = "Parameter type is invalid";
        break;
    case 1004:
        $mess = "Parameter value is invalid";
        break;
    case 1005:
        $mess = "Unknown error";
        break;
    case 1006:
        $mess = "File size is too big";
        break;
    case 1007:
        $mess = "Upload file failed";
        break;
    case 1008:
        $mess = "Maximum number of images";
        break;
    case 1009:
        $mess = "Not access";
        break;
    case 1010:
        $mess = "Action has been done previously by this user";
        break;
    case 1011:
        $mess = "This user logged in somewhere";
        break;
    }
    
    $res['code'] = ''.$code;
    $res['message'] = $mess;
    
    if(count($data) > 0){
        $res['data'] = $data;
    }
    
    echo json_encode($res);
}

require 'jwtHandler.php';

function GetToken($sdt, $id) {
    $jwt = new jwtHandler();
    $token = $jwt->_jwt_encode_data(
    'http://localhost/Zaloo/',
    array("sdt"=>$sdt,"id"=>$id)
    );
    
    $ng[$id] = $token;
    return $token;
}

function DecodeToken($tokn) {
    $jwt = new jwtHandler();
    $data =  $jwt->_jwt_decode_data(trim($tokn));
    $row = (array)$data;
    
    return $row;
}

function isAuth($tokn) {
    $jwt = new jwtHandler();
    $data =  $jwt->_jwt_decode_data(trim($tokn));
    $row = (array)$data;
    
    if(array_key_exists('id', $row)){
        return 1;
    } else{
        return 0;
    }
}

function uploadImage($folde) {
    if (!isset($_FILES["imageupload"]) || $_FILES["imageupload"]['error'] != 0)
  {
        return '';
  } else{
  // Đã có dữ liệu upload, thực hiện xử lý file upload

  //Thư mục bạn sẽ lưu file upload
  $target_dir    = "up/";
  //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
  $target_file   = $target_dir . basename($_FILES["imageupload"]["name"]);
  //Lấy phần mở rộng của file (jpg, png, ...)
  $filename = pathinfo($_FILES['imageupload']['name'], PATHINFO_FILENAME);
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  
  // move to folder
  $target_dir2   = $folde."/";
  $target_file2   = $target_dir2 . $filename.".".$imageFileType;

  $allowUpload   = true;
 
  // Cỡ lớn nhất được upload (bytes)
  $maxfilesize   = 5*1024*1024;  // 10Mb

  ////Những loại file được phép upload
  $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');


      //Kiểm tra xem có phải là ảnh bằng hàm getimagesize
  /*    $check = getimagesize($_FILES["imageupload"]["tmp_name"]);
      if($check !== false)
      {
          //echo "Đây là file ảnh - " . $check["mime"] . ".";
          $allowUpload = true;
      }
      else
      {
          //echo "Không phải file ảnh.";
          Respone(1007, []);
          die();
          
          $allowUpload = false;
      }*/

  // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
  // Bạn có thể phát triển code để lưu thành một tên file khác
  if (file_exists($target_file2))
  {
      //echo "Tên file đã tồn tại trên server, không được ghi đè";
      //$allowUpload = true;
      
      $addname = 1;
      while (true){
          $target_file2   = $target_dir2 . $filename.$addname.".".$imageFileType;
          if (file_exists($target_file2)){
              $addname++;
          } else{
              break;
          }
      }
      
  }
  // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
  if ($_FILES["imageupload"]["size"] > $maxfilesize)
  {
      $allowUpload = false;
      
       Respone(10062, []);
       die();
  }


  // Kiểm tra kiểu file
  if (!in_array($imageFileType,$allowtypes ))
  {
      //echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
      $allowUpload = false;
      
      Respone(10073, []);
      die();
  }


  if ($allowUpload)
  {
      // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
      if (move_uploaded_file($_FILES["imageupload"]["tmp_name"], $target_file2))
      {
        /*  echo "File ". basename( $_FILES["fileupload"]["name"]).
          " Đã upload thành công.";*/

        //  echo "File lưu tại " . $target_file;
        return $target_file2;
      }
      else
      {
          //echo "Có lỗi xảy ra khi upload file.";
          Respone(10074, []);
          die();
      }
  }
  else
  {
      //echo "Không upload được file, có thể do file lớn, kiểu file không đúng ...";
      Respone(10075, []);
      die();
  }
  }
}

function uploadVideo($folde) {
    if (!isset($_FILES["videoupload"]) || $_FILES["videoupload"]['error'] != 0)
  {
        return '';
  } else{

  // Đã có dữ liệu upload, thực hiện xử lý file upload

  //Thư mục bạn sẽ lưu file upload
  $target_dir    = "up/";
  //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
  $target_file   = $target_dir . basename($_FILES["videoupload"]["name"]);
  //Lấy phần mở rộng của file (jpg, png, ...)
  $filename = pathinfo($_FILES['videoupload']['name'], PATHINFO_FILENAME);
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  
  // move to folder
  $target_dir2   = $folde."/";
  $target_file2   = $target_dir2 . $filename.".".$imageFileType;

  $allowUpload   = true;
 
  // Cỡ lớn nhất được upload (bytes)
  $maxfilesize   = 30*1024*1024;  // 10Mb

  ////Những loại file được phép upload
  $allowtypes    = array('mp4', 'mp4');

  // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
  // Bạn có thể phát triển code để lưu thành một tên file khác
  if (file_exists($target_file2))
  {
      //echo "Tên file đã tồn tại trên server, không được ghi đè";
      //$allowUpload = true;
      
      $addname = 1;
      while (true){
          $target_file2   = $target_dir2 . $filename.$addname.".".$imageFileType;
          if (file_exists($target_file2)){
              $addname++;
          } else{
              break;
          }
      }
      
  }
  // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
  if ($_FILES["videoupload"]["size"] > $maxfilesize)
  {
      $allowUpload = false;
      
       Respone(1006, []);
       die();
  }


  // Kiểm tra kiểu file
  if (!in_array($imageFileType,$allowtypes ))
  {
      //echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
      $allowUpload = false;
      
      Respone(1007, []);
      die();
  }


  if ($allowUpload)
  {
      // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
      if (move_uploaded_file($_FILES["videoupload"]["tmp_name"], $target_file2))
      {
        /*  echo "File ". basename( $_FILES["fileupload"]["name"]).
          " Đã upload thành công.";*/

        //  echo "File lưu tại " . $target_file;
        return $target_file2;
      }
      else
      {
          //echo "Có lỗi xảy ra khi upload file.";
          Respone(1007, []);
          die();
      }
  }
  else
  {
      //echo "Không upload được file, có thể do file lớn, kiểu file không đúng ...";
      Respone(1007, []);
      die();
  }
  }
}

?>

