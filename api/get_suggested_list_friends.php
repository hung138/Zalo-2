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
            
            $inde = 0;
            if(!empty($_POST['index'])){
                $inde = $_POST['index'];
            }
            
            $count = 10;
            if(!empty($_POST['count'])){
                $count = $_POST['count'];
            }
            
            $conn = connectt();
            
            $queryy = "Select * from user where id = '$curr_id' and song = 0 ";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
            $bc = [];
        if ($soR > 0){
            $row = array();  
            if($inde == 0){
            $queryy = "Select u.* from user as u, banbe as b where b.tt = 2 "
                    . "and ((b.user1 = '$curr_id' and b.user2 = u.id) "
                    . "or (b.user2 = '$curr_id' and b.user1 = u.id)) ";
            } else{
                $queryy = "Select u.* from user as u, banbe as b where b.tt = 2 "
                    . "and ((b.user1 = '$curr_id' and b.user2 = u.id) "
                    . "or (b.user2 = '$curr_id' and b.user1 = u.id)) and stt > ".$inde;
            }
            
            $result = mysqli_query($conn, $queryy);
            $soR = mysqli_num_rows($result);
            $db = [];
            if ($soR > 0){
                $row = mysqli_fetch_all($result);
                foreach ($row as $va) {
                    $idd = $va[0];
                    $bc[] = $idd;
                    $sql = "Select distinct u.* from user as u, banbe as b where u.id != '$curr_id' and b.tt = 2 "
                    . "and ((b.user1 = '$idd' and b.user2 = u.id) "
                    . "or (b.user2 = '$idd' and b.user1 = u.id))";
                    $result = mysqli_query($conn, $sql);
                    
                    $ro = mysqli_fetch_all($result);
                    foreach ($ro as $v) {
                        $idd2 = $v[0];
                        $queryy2 = "Select * from banbe where tt = 2 "
                    . "and ((user1 = '$curr_id' and user2 = '$idd2') "
                    . "or (user2 = '$curr_id' and user1 = '$idd2')) ";
                        $result2 = mysqli_query($conn, $queryy2);
                        $soR2 = mysqli_num_rows($result2);
                        
                        if($soR2 == 0){
                            $db[] = $v;
                        }
                    }
                }
            }
            
            $d = [];
            
            $daCo = [];
            $banS = 'Suggested friend: ';
            $dem = 1;
            foreach ($db as $ve) {
                if($dem <= $count && !in_array($ve[0], $daCo)){
                    $d[$banS.$dem]['id'] = $ve[0];
                    $d[$banS.$dem]['name'] = $ve[1];
                    $d[$banS.$dem]['avatar'] = $ve[4];
                    
                    $iddd2 = $ve[0];
                    
                    $demBC = 0;
                    foreach ($bc as $b) {
                        $idC = $b;
                        $quryy2 = "Select * from banbe where tt = 2 "
                    . "and ((user1 = '$b' and user2 = '$idd2') "
                    . "or (user2 = '$b' and user1 = '$idd2')) ";
                        $reslt2 = mysqli_query($conn, $quryy2);
                        $soRr2 = mysqli_num_rows($reslt2);
                        
                        if($soRr2 > 0){
                            $demBC++;
                        }
                    }
                    $d[$banS.$dem]['same_friends'] = $demBC;
                    
                    $daCo[] = $ve[0];
                    $dem++;
                }    
            }
            
            Respone(1000, $d);
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





