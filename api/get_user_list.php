<?php

include 'dbCon.php';

function GetListUser() {
    if(empty($_POST['token']) || empty($_POST['start_user_id']) || empty($_POST['count'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $id = $_POST['start_user_id'];      
            $count = $_POST['count'];

            if($count <= 0 || $id < 0){
                Respone(1004, []);
                die();
            }

            $queryy = "Select * from user where id >= '$id' limit ".$count;
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_all($result);           
            
            $db = [];
            $tde = 'user ';
            $dem = 1;

            foreach ($row as $va) {
                $db[$tde.$dem]['user_id'] = $va[0];
                $db[$tde.$dem]['user_name'] = $va[1];
                $db[$tde.$dem]['link'] = $va[4];
                $db[$tde.$dem]['online'] = '';
                $db[$tde.$dem]['isActive'] = $va[6];
                $db[$tde.$dem]['lastLogin'] = $va[7];
                
                $dem++;
            }
            
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

GetListUser();
?>








