<?php
include 'dbCon.php';

function Report() {
    if(empty($_POST['token']) || empty($_POST['id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $bv_id = $_POST['id'];           
            $subj = 0;
            if(!empty($_POST['subject'])){
                $subj = $_POST['subject'];
            }
            
            $detail = '';
            if(!empty($_POST['details'])){
                $detail = $_POST['details'];
            }
            
            $queryy = "Select * from baiviet where id = '$bv_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_array($result);
            if($row['locked'] == 1){
                Respone(1010, []);
                die();
            }
            
            $queryy2 = "INSERT INTO report (stt, id_baiviet, subject, details) VALUES "
                . "('null', '$bv_id', '$subj', '$detail')";
            $result2 = mysqli_query($conn, $queryy2); 
            if($result2){
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
Report();
?>


