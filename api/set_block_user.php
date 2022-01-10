<?php
include 'dbCon.php';

function SetBlock() {
    if(empty($_POST['token']) || empty($_POST['user_id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
           
            $u_id = $_POST['user_id'];
            $type = $_POST['type'];
            $type = strval($type);
            
            if($type < 0 || $type > 1){
                Respone(1004, []);
                die();
            }
            $conn = connectt();
            
            $queryy = "Select * from user where id = '$curr_id' or id = '$u_id' and song = 0";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 1){ 
 
            if($type == 0){
                $sql = "INSERT INTO block (id_user_block, id_user_bi_block, stt) VALUES "
                . "('$curr_id', '$u_id', 'null')";
                $result = mysqli_query($conn, $sql);
            } else{
               $sql = "Delete from block where id_user_block = '$curr_id' and id_user_bi_block = '$u_id'";
                $result = mysqli_query($conn, $sql);
            }
                
            Respone(1000, []);
        } else{
            Respone(9995, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
SetBlock();
?>








