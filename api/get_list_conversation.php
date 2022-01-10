<?php

include 'dbCon.php';

function GetListConver() {
    if(empty($_POST['token']) || empty($_POST['index']) || empty($_POST['count'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $id  = 0;
            if(!empty($_POST['index'])){
                $id = $_POST['index'];
            }
            
            $count = 20;
            if(!empty($_POST['count'])){
                $count = $_POST['count'];
            }
            if($count <= 0 || $id < 0){
                Respone(1004, []);
                die();
            }

            $queryy = "Select user1, user2, count(user1) from chat where user1 = ".$id." or user2 = ".$id." "
                    . "group by user1, user2 ";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_all($result);           
            
            $db = [];
            $tde = 'Conversation ';
            $dem = 1;
            
            $u1 = 0;
            $u2 = 0;
            $uK = [];
            $tnChuaDoc = 0;
            foreach ($row as $va) {
                if(!in_array($va[0], $uK) && !in_array($va[1], $uK) && $dem <= $count){
                    $u1 = $va[0];
                    $u2 = $va[1];
                
                if($va[0] == $id){
                    $u1 = $va[0];
                    $u2 = $va[1];
                } else{
                    $u1 = $va[1];
                    $u2 = $va[0];
                }
                $uK[] = $u2;
                $db[$tde.$dem]['id'] = $dem;
                
                $queryy = "Select * from user where id = ".$u2;
                $result = mysqli_query($conn, $queryy);
                $row1 = mysqli_fetch_array($result); 
                $db[$tde.$dem]['partner']['id'] = $u2;
                $db[$tde.$dem]['partner']['username'] = $row1[1];
                $db[$tde.$dem]['partner']['avatar'] = $row1[4];
                
                $queryy = "Select * from chat where (user1 = ".$u1." and user2 = ".$u2.") "
                        . " or (user1 = ".$u2." and user2 = ".$u1.") order by stt desc limit 1";
                $result = mysqli_query($conn, $queryy);
                $row2 = mysqli_fetch_array($result);     
                
                $db[$tde.$dem]['last message']['message'] = $row2[2];
                $db[$tde.$dem]['last message']['created'] = $row2[4];
                if($row2[6] == '0'){
                    $db[$tde.$dem]['last message']['unread'] = '1';
                } else {
                    $db[$tde.$dem]['last message']['unread'] = '0';
                }
                
                $queryy = "Select * from chat where ((user1 = ".$u1." and user2 = ".$u2.") "
                        . " or (user1 = ".$u2." and user2 = ".$u1.")) and tt = 0";
                $result = mysqli_query($conn, $queryy);
                $row3 = mysqli_num_rows($result);
                if($row3 > 0){
                    $tnChuaDoc++;
                }
                $dem++;
            }}
            
            
            $db['numNewMessage'] = $tnChuaDoc;
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

GetListConver();
?>






