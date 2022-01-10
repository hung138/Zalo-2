<?php
include 'dbCon.php';

function GetUserInfo() {
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
            $queryy = "Select * from user where id = '$idd'";
            $result = mysqli_query($conn, $queryy);
            
            $soR = mysqli_num_rows($result);
            if ($soR > 0){
                $row1 = mysqli_fetch_array($result);  
                
                $db = [];
                $db['user_id'] = $row1[0];
                $db['user_name'] = $row1[1];
                $db['image'] = $row1[4];
                $db['online'] = '';
            if($row1[6] == '0'){
                $db['isActive'] = '1';
            } else{
                $db['isActive'] = '0';
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





