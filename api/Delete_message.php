<?php
include 'dbCon.php';

function DelCom() {
    if(empty($_POST['token']) || empty($_POST['message_id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $m_id = $_POST['message_id'];
            
            $queryy = "Select * from chat where stt = '$m_id' ";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $sql4 = "Delete from chat where stt = '$m_id'";
            $result4 = mysqli_query($conn, $sql4);
            
            if($result4){
                Respone(1000, []);
            } else{
                Respone(1001, []);
            }
        } else{
            Respone(9992, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
DelCom();
?>




