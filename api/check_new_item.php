<?php
include 'dbCon.php';

function GetListPost() {
    if(empty($_POST['token'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $bv_id  = 0;
            if(!empty($_POST['last_id'])){
                $bv_id = $_POST['last_id'];
            }
            
            $c_id  = 0;
            if(!empty($_POST['category_id'])){
                $c_id = $_POST['category_id'];
            }
            
            if($bv_id < 0 || $c_id > 3 || $c_id < 0){
                Respone(1004, []);
                die();
            }
            
            $queryy = "Select id from baiviet where id > ".$bv_id;
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){        
            $db = [];
            $db['new items'] = $soR;
            
            Respone(1000, $db);
        } else{
            Respone(9994, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}

GetListPost();

?>

