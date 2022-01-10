<?php
include 'dbCon.php';

function SetInfo() {
    if(empty($_POST['token']) || empty($_POST['user_name'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
                      
            $name = $_POST['user_name'];
            $dchi = 'http://localhost/Zaloo/api/';
            $avat = $dchi.uploadImage('avatar');
            
            if($avat == $dchi){
                Respone(1002, []);
                die();
            }
            
            $queryy = "Select * from user where id = '$curr_id' and song = 0 ";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_array($result);           
            
            $queryy = "Update user set tenDN = '$name', linkAvatar = '$avat' where id = '$curr_id' ";
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

SetInfo();
?>


