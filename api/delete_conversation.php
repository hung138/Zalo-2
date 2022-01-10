<?php
include 'dbCon.php';

function DelCom() {
    if(empty($_POST['token']) || empty($_POST['partner_id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $part_id = $_POST['partner_id'];
            
            $queryy = "Select * from chat where (user1 = '$part_id' and user2 = '$curr_id') "
                    . "or (user1 = '$curr_id' and user2 = '$part_id')";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $sql4 = "Delete from chat where (user1 = '$part_id' and user2 = '$curr_id') "
                    . "or (user1 = '$curr_id' and user2 = '$part_id')";
            $result4 = mysqli_query($conn, $sql4);
            
            if($result4){
                Respone(1000, []);
            } else{
                Respone(1001, []);
            }
        } else{
            Respone(9994, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
DelCom();
?>


