<?php

function GuiTinNhan(){
    if(empty($_POST['token'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $user1 = $db['id'];
            
            $conn = connectt();
            
            $user2 = $_POST['guiChatId'];
            $message = $_POST['message'];
    
            date_default_timezone_set("Asia/Bangkok");
            $ngay = date('Y-m-d H:i:s', time());
    
            $queryy = "INSERT INTO chat (user1, user2, noidung, media, ngay, tt) VALUES "
                . "('$user1', '$user2', '$message', '', '$ngay', 0)";
            
            if(mysqli_query($conn, $queryy)){
                Respone(1000, []);
            } else{
                Respone(1001, []);
            }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }    
}

?>

