<?php
include 'dbCon.php';

function SetAccept() {
    if(empty($_POST['token']) || empty($_POST['user_id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
           
            $u_id = $_POST['user_id'];
            
            $conn = connectt();
            
            $queryy = "Select * from user where id = '$curr_id' or id = '$u_id' and song = 0";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 1){ 
            $queryy2 = "Select * from banbe where user1 = '$curr_id' and user2 = '$u_id' ";
            $result2 = mysqli_query($conn, $queryy2);
        
            $soR = mysqli_num_rows($result2);
            
            if($soR > 0){
                $sql = "Update banbe set tt = '1' where user1 = '$curr_id' and user2 = '$u_id'";
                $result = mysqli_query($conn, $sql);
            } else{
                date_default_timezone_set("Asia/Bangkok");
                $ngay = date('Y-m-d H:i:s', time());
            
                $sql = "INSERT INTO banbe (user1, user2, stt, tt, ngay) VALUES "
                . "('$curr_id', '$u_id', 'null', '1', '$ngay')";
                $result = mysqli_query($conn, $sql);
            }
          
            $db = [];
            $sql = "Select * from banbe where tt = '1' and user1 = '$curr_id'";
            $result = mysqli_query($conn, $sql);
            $soR = mysqli_num_rows($result);
            $db['requested_friends'] = $soR;
                
            Respone(1000, $db);
        } else{
            Respone(9995, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
SetAccept();
?>







