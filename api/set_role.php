<?php

include 'dbCon.php';

function SetRole() {
    if(empty($_POST['token']) || empty($_POST['role']) || empty($_POST['user_id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $idd  = $_POST['user_id'];           
            $role = $_POST['role'];

            if($role < 0 || $role > 2 || $idd < 0){
                Respone(1004, []);
                die();
            }

            $queryy = "Select quyen from user where id = '$curr_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_array($result);           
            
            if($row[0] != 3){
                Respone(1009, []);
                die();
            }
            $queryy = "Update user set quyen = '$role' where id = '$idd' ";
            $result = mysqli_query($conn, $queryy);
            
            Respone(1000, []);
        } else{
            Respone(9994, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}

SetRole();
?>








