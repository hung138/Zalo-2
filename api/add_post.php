<?php
include 'dbCon.php';

function GuiPost() {
    if(empty($_POST['token'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            
            $conn = connectt();
    
            $curr_id = $db['id'];
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
    
            $queryy = "INSERT INTO baiviet (id, id_user, noidung, media, media2, tgTao) VALUES "
                . "('null', '$curr_id', '$message', '$media', '$media2', '$ngay')";
            if (mysqli_query($conn, $queryy)){
                
                $queryy2 = "Select * from baiviet where id_user = '$curr_id' Order By id DESC LIMIT 1";
                $result2 = mysqli_query($conn, $queryy2);
                $row = mysqli_fetch_array($result2);
            
                $db = [];
                $db['id'] = $row['id'];
                $db['url'] = '';
                $db['owner'] = $row['id_user'];
                
                Respone(1000, $db);
            }else {
                Respone(1001, []);
            }
            
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
GuiPost();
?>
