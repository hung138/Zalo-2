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
            $acc = $_POST['is_accept'];
            
            if($acc > 1 || $acc < 0){
                Respone(1004, []); 
                die();
            }
            
            $conn = connectt();
            
            $queryy = "Select * from user where id = '$curr_id' or id = '$u_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 1){ 
            $queryy = "Select * from banbe where tt = '1' and user1 = '$u_id' and user2 = '$curr_id' ";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
            
            if($soR == 1){
            if($acc == 1){
                $sql = "Update banbe set tt = '2' where user1 = '$u_id' and user2 = '$curr_id'";
                $result = mysqli_query($conn, $sql);
            } else{
                $sql = "Update banbe set tt = '0' where user1 = '$u_id' and user2 = '$curr_id'";
                $result = mysqli_query($conn, $sql);
            }
                Respone(1000, []);
            } else{
                Respone(9997, []);
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
SetAccept();
?>





