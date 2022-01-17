const DoiTT = document.getElementById('DoiTT');
const DoiTT2 = document.getElementById('DoiTT2');
const DSUser = document.getElementById('dsuser');

CheckTok();
function CheckTok(){
    var tok = sessionStorage.getItem("token");
    //console.log(tok);
    
    if(tok == '' || tok == null){
        alert('Hay dang nhap');
        window.location = 'login.php';
    } else{
        GetUserInfo();
    }
}

function GetUserInfo(){
    var tok = sessionStorage.getItem("token");
    var id = sessionStorage.getItem("user_id");
    
       $.ajax({
        url:"home.php",
        method:"POST",
        data:{get_info: 1, token: tok, user_id: id},
        dataType:"JSON",
        
        success : function (result){
           console.log(result);
            var dc = result['code'];
            var mess = result['message'];
            if(dc == '1000'){
                //alert(mess);
                var tenn = result['data']['user_name'];
                var haa = result['data']['image'];
                HienThiUserInFor(tenn, haa);
            } else{
                alert(mess + ", hay dang nhap");
                window.location = 'login.php';
            }  
        }
    }); 
}

function HienThiUserInFor(ten, ha){
    var tenHT = document.getElementById('tenUser');
    tenHT.appendChild(document.createTextNode(ten));

    $("#anhdd").attr("src", ha);
}

function LogOutt(){
    var tok = sessionStorage.getItem("token");
    
       $.ajax({
        url:"home.php",
        method:"POST",
        data:{get_out: 1, tokken: tok},
        dataType:"JSON",
        
        success : function (result){
           console.log(result);
            var dc = result['code'];
            var mess = result['message'];
            if(dc == '1000'){
                sessionStorage.clear();
                
                alert(mess);
                window.location="home.php";
            } else{
                alert(mess);
            }  
        }
    }); 
}

$(document).on('click', "#dangxuat", function () {
    LogOutt();
});

function LayDSUser(){
    var tok = sessionStorage.getItem("token");
    var idd = sessionStorage.getItem("user_id");
    
       $.ajax({
        url:"home.php",
        method:"POST",
        data:{get_user_list: 1, token: tok, start_user_id: 1, count: 100},
        dataType:"JSON",
        
        success : function (result){
            var dc = result['code'];
            var mess = result['message'];
            if(dc == '1000'){
                //alert(mess);
                HienThiDsUser(result['data'], idd);
            } else{
                //alert(mess);
            }  
        }
    }); 
}

function HienThiDsUser(danhsach, id){
    DSUser.innerHTML = '';
    
    var tong  = Object.keys(danhsach).length
    for (var i = 0; i < tong; i++) {
        var d = i+1;
        var dd = 'user ' + d;
         var d_id = danhsach[dd]['user_id'];
        
        if(d_id != id){
        var divv = document.createElement('div');
        divv.setAttribute('style', 'width: 100%; height: 50px;border: 1px solid #ddd;background: #ffffff;');
        
        var ava = document.createElement('img');
        ava.setAttribute('src', '' + danhsach[dd]['link']);
        divv.appendChild(ava);
        ava.setAttribute('style','width: 30p; height: 30px;margin-top: 10px; margin-left: 15px;border-radius: 50%;float: left;');
    
        var pp = document.createElement('label');
        pp.appendChild(document.createTextNode(danhsach[dd]['user_name']));
        divv.appendChild(pp);
        pp.setAttribute('style', 'margin-top: 15px; margin-left: 15px;float: left;text-align: left;text-transform: uppercase;');
        
        var butn2 = document.createElement('img');
        butn2.setAttribute('src','source/mesa.png');
        butn2.name = danhsach[dd]['user_id'];
        butn2.id = 'Chat';
        divv.appendChild(butn2);
        butn2.setAttribute('style', 'float: right;margin-top: 10px; margin-right: 5px; \n\
        width: 30px; height: 30px;text-transform: uppercase;cursor: pointer;');    
        
        DSUser.appendChild(divv);
    }
    }
}

$(document).on('click', "#danhsachuser", function () {
    LayDSUser();
});


$(document).on('click', "#Cancel2", function () {
    DoiTT2.innerHTML = '';
});

// chat
function GetCoversation(idd, tenn){
    var tok = sessionStorage.getItem("token");
    var idDetail = idd;
    
    $.ajax({
        url:"home.php",
        method:"POST",
        data:{moChatId: 1, token: tok, index: 0, partner_id: idDetail, count: 20},
        dataType:"JSON",
        
        success : function (result){ 
            console.log(result);
           
            var dc = result['code'];
            var mess = result['message'];
            if(dc == '1000'){
                //alert(mess);
                var chatArr = result['data'];
                MoChat(chatArr, tenn, idDetail);
            } else{
                //alert(mess);
            }  
        }
    });
}

$(document).on('click', "#Chat", function () {
    var tok = sessionStorage.getItem("token");
    var idDetail = parseInt($(this).attr('name'));
    
    var chuaTen = $(this).parent().children('label')[0];
    var tenn = chuaTen.childNodes[0].nodeValue;
    
   /* var chuaHa = $(this).parent().children('img')[0];
    var haa = chuaHa.getAttribute("src");*/
    $.ajax({
        url:"home.php",
        method:"POST",
        data:{moChatId: 1, token: tok, index: 0, partner_id: idDetail, count: 20},
        dataType:"JSON",
        
        success : function (result){ 
            //console.log(result);
           
            var dc = result['code'];
            var mess = result['message'];
            if(dc == '1000'){
                //alert(mess);
                var chatArr = result['data'];
                MoChat(chatArr, tenn, idDetail);
            } else{
                //alert(mess);
            }  
        }
    });
});

var chatIDOpen = 0;
var chatName = '';

function MoChat(chatAr, ten, idd){
    DoiTT2.innerHTML = '';
    
    var divv = document.createElement('div');
    divv.id = 'chat_frame';
    divv.setAttribute('style', 'border: #E8E9EC solid 10px;background-color:#FFF;\n\
width: 100%;height: 100%;float:right;position:relative;');
    
     var Huydi = document.createElement('input');
    Huydi.setAttribute('type', 'button');
    Huydi.value = 'Đóng';
    Huydi.id = 'Cancel2';
    divv.appendChild(Huydi);
    Huydi.setAttribute('style', 'background: #69d2e7;border: 1px solid #ddd;color: #ffffff\n\
;width: 60px; height: 30px;text-transform: uppercase;float:right;');
    
    var pp = document.createElement('label');
    pp.appendChild(document.createTextNode('Chat with ' + ten));
    divv.appendChild(pp);
    pp.setAttribute('style', 'margin-top: 10px; margin-left: 15px;');
            
    // doan chat
    var divChat = document.createElement('div');
    divChat.id = 'chatRoom';
    divv.appendChild(divChat);
    divChat.setAttribute('style', 'background-color:#FFF;width: 100%;max-height: 80%;overflow: auto;scrollbar-width: none;');
    
    // xu ly doan chat
    var soLg = Object.keys(chatAr).length - 1;
    
    if(soLg > 0){
    var PreUser = null;
    var userID = sessionStorage.getItem("user_id");
    
    if(soLg > 2){
    for(var i = 0; i < soLg - 2; i++){
        for(var j = i + 1; j < soLg - 1; j++){
            var di = i+1;
            var dj = j+1;
            
            var soi = parseInt(chatAr['Conversation ' + di]['id']);
            var soj = parseInt(chatAr['Conversation ' + dj]['id']);
            
            if(soi < soj){
                var tt = chatAr['Conversation ' + di];
                chatAr['Conversation ' + di] = chatAr['Conversation ' + dj];
                chatAr['Conversation ' + dj] = tt;
            }
        }
    }
    }
    
        console.log(chatAr);
    
    for(var i = soLg; i > 0; i--){
        var vt = i;
        var messa = chatAr['Conversation ' + vt];
 
        const tenNode = document.createElement('div');
        var sender = messa['sender']['id'];
        
        if(sender == userID){
            if(PreUser == null || sender != PreUser){
                tenNode.innerHTML = 'You';
	        tenNode.setAttribute("style", "margin-right: 10px;max-width: 70%;clear: both;font-size: 13px;text-align: right;float:right;");
            }
        } else{
            if(PreUser == null || sender != PreUser){
                const avaNode = document.createElement('IMG');
	        avaNode.src = messa['sender']['avatar'];
	        avaNode.setAttribute("style", "width: 30px; height: 30px;clear: both; margin-top: 10px; margin-left: 10px;border-radius: 50%;float:left;cursor: pointer;");
	        divChat.appendChild(avaNode);
                
                tenNode.innerHTML = messa['sender']['username'];
	        tenNode.setAttribute("style", "margin-left: 10px;max-width: 70%;clear: both;font-size: 13px;text-align: left;float:left;");
            }
        }
		
	divChat.appendChild(tenNode);
	
        // tin nhan
        if(messa[2] != ''){
	const chatNode = document.createElement('div');
        var mes = messa['message'];
     //   console.log(mes);
        chatNode.innerText = mes;
	if(sender == userID){
	    chatNode.setAttribute("style","margin-right: 10px; padding: 10px; max-width: 70%;word-wrap: break-word;clear: both;text-align: right;font-size: 20px;line-height: 26px;background: #06F;color: #FFF;border-radius: 8px 8px 0 8px;margin-top: 1px; float:right;");
	} else{
	    chatNode.setAttribute("style","margin-left: 10px; padding: 10px; max-width: 70%;word-wrap: break-word;clear: both;text-align: left;font-size: 20px;line-height: 26px;background: #ebebeb;color: #000;border-radius: 8px 8px 8px 0;margin-top: 1px;float:left;");
	}		
	divChat.appendChild(chatNode);
        }
        PreUser = sender;
    }}
    
    // gui tin nhan
    var divSend = document.createElement('div');
    divSend.id = 'chatRoom';
    divSend.setAttribute('style', 'background-color:#CCC;width: 100%;height: 13%;position:absolute; bottom: 0;');
    
    var chatText = document.createElement('textarea');
    chatText.id = 'message';
    chatText.placeholder = 'chat here...';
    divSend.appendChild(chatText);
    chatText.setAttribute('style', 'width: 96.8%;height: 50%;margin-top:10px;margin-left:5px;padding: 8px;');
    
    var sendBtn = document.createElement('img');
    sendBtn.setAttribute('src', 'source/sendB.png');
    sendBtn.id = 'sendMess';
    divSend.appendChild(sendBtn);
    sendBtn.setAttribute('style', ' width: 12%;height: 40%;float:right;cursor: pointer;');
    
    divv.appendChild(divSend);
    
    DoiTT2.appendChild(divv);
    divChat.scrollTop = divChat.scrollHeight;
    
    chatIDOpen = idd;
    chatName = ten;
}

$(document).on('click', "#sendMess", function () {  
    var tok = sessionStorage.getItem("token");
    var userID = sessionStorage.getItem("user_id");
    
    var idDetail = chatIDOpen;
    var tin = $('#message').val();
    
    var dataMess = [userID, idDetail];
    if(tin != ''){
    $.ajax({
        url:"home.php",
        method:"POST",
        data:{guiChatId: idDetail, token: tok, message: tin},
            dataType: 'JSON',
            
        success : function (result){ 
            console.log(result);
           
            var dc = result['code'];
            var mess = result['message'];
            if(dc == '1000'){
                //alert(mess);  
                console.log('gui thanh cong');
                GetCoversation(chatIDOpen, chatName);
                socket.emit('CO_NGUOI_GUI_TIN_NHAN', dataMess);
            } else{
                alert(mess);
            }  
        }
    });
    }
});

// socket connect
let socket = io.connect('http://localhost:3000'); 
socket.on('connect', () => {
  //  const myID = socket.id;
    console.log(socket.id);
    var userID = sessionStorage.getItem("user_id");
    if(userID != null){
        DangHoatDong(userID, socket.id);
    }
});

function DangHoatDong(myid, mySocketId){
    socket.emit('CO_NGUOI_ONLINE', {id: myid, socid: mySocketId});
}

socket.on('KO_THE_DANG_NHAP', () =>{
    $('#dangxuat').click();
    alert('Tai khoan dang duoc dang nhap o noi khac');
});

socket.on('CO_TIN_NHAN', messa =>{
    var idDetail = messa[0];
    if(chatIDOpen == idDetail && DoiTT2.innerHTML != ''){
        GetCoversation(idDetail, chatName);
    }
});