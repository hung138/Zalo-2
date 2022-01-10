<?php
include 'dbCon.php';

function EditPost() {
    if(empty($_POST['token']) || empty($_POST['id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $bv_id = $_POST['id'];
            
            $queryy = "Select * from baiviet where id = '$bv_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $message = $_POST['described'];
    
            $dchi = 'http://localhost/Zaloo/api/';
            $media = $dchi.uploadImage('post/img');
            $media2 = $dchi. uploadVideo('post/video');
    
            if($media != $dchi && $media2 != $dchi){
                Respone(1008, []);
                die();
            } else {
                if($media == $dchi){
                    $media = '';
                }
                
                if($media2 == $dchi){
                    $media2 = '';
                }
            }
    
            date_default_timezone_set("Asia/Bangkok");
            $ngay = date('Y-m-d H:i:s', time());
    
            $queryy = "Update baiviet set noidung = '$message', media = '$media', media2 = '$media2' "
                    . "where id = '$bv_id' ";
            if (mysqli_query($conn, $queryy)){
                Respone(1000, []);
            }else {
                Respone(1001, []);
            }
        } else{
            Respone(9992, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
EditPost();
?>

