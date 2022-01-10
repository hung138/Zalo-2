<?php
include 'dbCon.php';

function GetUserInfo() {
    if(empty($_POST['token'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $idd  = $curr_id;
            if(!empty($_POST['user_id'])){
                $idd = $_POST['user_id'];
            }       

            $queryy = "Select quyen from user where id = '$curr_id' and song = 0";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $queryy = "Select * from user where id = '$idd' and song = 0";
            $result = mysqli_query($conn, $queryy);
            
            $soR = mysqli_num_rows($result);
            if ($soR > 0){
                $row1 = mysqli_fetch_array($result);  
                
                $db = [];
                $db['user_id'] = $row1[0];
                $db['user_name'] = $row1[1];
                $db['online'] = '';
            if($row1[6] == '0'){
                $db['isActive'] = '1';
            } else{
                $db['isActive'] = '0';
            }
            
            $sql = "Select * from banbe where tt = 2 and user1 = '$idd' or user2 = '$idd'";
            $result = mysqli_query($conn, $sql);
            $coBan = mysqli_num_rows($result);
            $db['listing'] = $coBan;
            
            if($curr_id != $idd){
            $sql = "Select * from banbe where tt = 2 and ((user1 = '$curr_id' and user2 = '$idd') "
                    . "or (user1 = '$idd' and user2 = '$curr_id'))";
            $result = mysqli_query($conn, $sql);
            $coBan = mysqli_num_rows($result);
            if($coBan > 0){
                $db['is_friend'] = 'Yes';
            } else{
                $db['is_friend'] = 'No';
            }} else{
                $db['is_friend'] = '';
            }
                
                Respone(1000, $db);
            } else {
                Respone(9995, []);
            }
        } else{
            Respone(9995, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}

GetUserInfo();
?>







