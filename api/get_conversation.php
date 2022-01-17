<?php
include 'dbCon.php';

function GetChat() {
if(empty($_POST['token']) || empty($_POST['partner_id']) || empty($_POST['count'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $part_id = $_POST['partner_id'];
            $id = 0;
            if(!empty($_POST['index'])){
                $id = $_POST['index'];
            }
            
            $count = $_POST['count'];
            
          if($id > 0){
            $queryy = "Select * from chat where ((user1 = '$curr_id' and user2 = '$part_id') "
                    . "or (user1 = '$part_id' and user2 = '$curr_id')) and stt < ".$id." order by stt desc limit ".$count;
            
            } else{
                $queryy = "Select * from chat where (user1 = '$curr_id' and user2 = '$part_id') "
                    . "or (user1 = '$part_id' and user2 = '$curr_id') order by stt desc limit ".$count;
            }
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        //if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_all($result);      
            
            $db = [];
            $tde = 'Conversation ';
            $dem = 1;
            
            foreach ($row as $va) {
                if($va[6] == '1'){
                $db[$tde.$dem]['id'] = $va[5];
                $db[$tde.$dem]['message'] = $va[2];
                if($va[6] == '0'){
                    $db[$tde.$dem]['unread'] = '1';
                } else {
                    $db[$tde.$dem]['unread'] = '0';
                }
                $db[$tde.$dem]['created'] = $va[4];
                
                $queryy1 = "Select * from user where id = ".$va[0];
                $result1 = mysqli_query($conn, $queryy1);
                $row1 = mysqli_fetch_array($result1); 
                $db[$tde.$dem]['sender']['id'] = $row1[0];
                $db[$tde.$dem]['sender']['username'] = $row1[1];
                $db[$tde.$dem]['sender']['avatar'] = $row1[4];

                $dem++;
                }
            }
            
            foreach ($row as $va) {
                if($va[6] == '0'){
                $db[$tde.$dem]['id'] = $va[5];
                $db[$tde.$dem]['message'] = $va[2];
                if($va[6] == '0'){
                    $db[$tde.$dem]['unread'] = '1';
                } else {
                    $db[$tde.$dem]['unread'] = '0';
                }
                $db[$tde.$dem]['created'] = $va[4];
                
                $queryy1 = "Select * from user where id = ".$va[0];
                $result1 = mysqli_query($conn, $queryy1);
                $row1 = mysqli_fetch_array($result1); 
                $db[$tde.$dem]['sender']['id'] = $row1[0];
                $db[$tde.$dem]['sender']['username'] = $row1[1];
                $db[$tde.$dem]['sender']['avatar'] = $row1[4];

                $dem++;
                }
            }
            
            $sql5 = "Select * from block where id_user_block = '$id' and id_user_bi_block = '$part_id'";
            $result5 = mysqli_query($conn, $sql5);
            if (mysqli_num_rows($result5) > 0)
            {  
                $db['is_blocked'] = 'Yes';
            } else{
                $db['is_blocked'] = 'No';
            }
  
            Respone(1000, $db);
        } else{
            Respone(9992, []);
        }
      /*  } else{
            // toke is invalid
            Respone(9998, []);
        }*/
    }
}
GetChat();
?>




