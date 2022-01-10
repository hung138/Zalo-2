<?php
include 'dbCon.php';

function SetRole() {
    if(empty($_POST['token']) || empty($_POST['user_id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $idd  = $_POST['user_id'];           
            $stat = $_POST['state'];
            
            if($stat == '0'){
                $stat = 1;
            } else {
                $stat = 0;
            }

            if($stat < 0 || $stat > 1 || $idd < 0){
                Respone(1004, []);
                die();
            }

            $queryy = "Select quyen from user where id = '$curr_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_array($result);           
            
            if($row[0] < 2){
                Respone(1009, []);
                die();
            }
            $queryy = "Update user set song = '$stat' where id = '$idd' ";
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

