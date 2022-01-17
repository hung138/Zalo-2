<?php
include 'dbCon.php';

function GetPost() {
    if(empty($_POST['token'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            if(!empty($_POST['user_id'])){
                $curr_id = $_POST['user_id'];
            }
            
            $count = 10;
            if(!empty($_POST['count'])){
                $count = $_POST['count'];
            }
            
            $inde = 0;
            if(!empty($_POST['index'])){
                $inde = $_POST['index'];
            }
            
            $conn = connectt();
            
            $queryy = "Select * from user where id = '$curr_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();   
                $queryy = "Select u.* from user as u, banbe as b where b.tt = 2 "
                    . "and ((b.user1 = '$curr_id' and b.user2 = u.id) "
                    . "or (b.user2 = '$curr_id' and b.user1 = u.id)) and b.stt >= '$inde' limit ".$count;
            $result = mysqli_query($conn, $queryy);
            $soR = mysqli_num_rows($result);
            $db = [];
            if ($soR > 0){
                $row = mysqli_fetch_all($result);
                $tenP = 'Friend ';
                $dem = 1;
                foreach ($row as $va) {
                    $db[$tenP.$dem]['id'] = $va[0];
                    $db[$tenP.$dem]['name'] = $va[1];
                    $db[$tenP.$dem]['sdt'] = $va[3];
                    $db[$tenP.$dem]['avatar'] = $va[4];
                    $dem++;
                }

            }
            
            Respone(1000, $db);
        } else{
            Respone(9995, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
GetPost();
?>



