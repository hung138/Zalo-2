<?php
include 'dbCon.php';

function ChangePass() {
    if(empty($_POST['token']) || empty($_POST['password']) || empty($_POST['new_password'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $pass1 = $_POST['password'];
            $pass2 = $_POST['new_password'];
            
            if(strlen(trim($pass1)) < 8 || strlen(trim($pass2)) < 8){
                Respone(1004, []); 
                die();
            }
            
            $queryy = "Select * from user where id = '$curr_id' and song = 0 ";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = mysqli_fetch_array($result);
     
            if($row[2] == $pass1){
                $queryy = "Update user set matkhau = '$pass2' where id = '$curr_id'";
                $result = mysqli_query($conn, $queryy);
                
                Respone(1000,[]);
            } else{
                $dbb['report'] = 'Mat khau cu khong dung';
                Respone(1004, $dbb);
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
ChangePass();
?>






