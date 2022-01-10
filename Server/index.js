var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

server.listen(3000);

const arrUser = [];
//const arrChat = [];

io.on('connection', socket =>{

        socket.on('CO_NGUOI_ONLINE', user =>{
                const found = arrUser.findIndex(e => e.id == user.id);
                console.log(found);
		if(found != -1){
	        //    arrUser.splice(found, 1);
	        //    arrUser.push(user);
                    console.log('Co nguoi dang nhap o noi khac');
                    console.log(user);
                    
                //    io.emit('DANH_SACH_USER_ONLINE', arrUser);
                    socket.emit('KO_THE_DANG_NHAP');
		} else{
                    arrUser.push(user);
                    console.log('Add new user');
                    console.log(user);
                    //io.emit('DANH_SACH_USER_ONLINE', arrUser);
                }         
	});
        
        socket.on('CO_NGUOI_GUI_TIN_NHAN', data =>{
                const found = arrUser.findIndex(e => e.id == data[0]);
		if(found !== -1){
                    console.log('Tin nhan tu ');
                    console.log(arrUser[found]);
                    //socket.emit('SHOW_TIN_NHAN', data);
		}
                
                const found2 = arrUser.findIndex(e => e.id == data[1]);
		if(found2 !== -1){
                    console.log('Tin nhan toi ')
                    console.log(arrUser[found2]);
                    io.to(arrUser[found2].socid).emit('CO_TIN_NHAN', data);
		}
	});
        
    /*    socket.on('CO_NGUOI_GUI_BINH_LUAN', data =>{
                const found = arrUser.findIndex(e => e.id == data[0]);
		if(found !== -1){
                    console.log('Binh luan cua ');
                    console.log(arrUser[found]);
                    io.emit('CO_BINH_LUAN_MOI', data);
		}
	});*/
        
        socket.on('disconnect', () =>{
		const found = arrUser.findIndex(e => e.socid == socket.id);
		if(found != -1){
                    console.log('User offline');
                    console.log(arrUser[found]);
	            arrUser.splice(found, 1);
                    
		    //io.emit('DANH_SACH_USER_ONLINE', arrUser);
		}
	});
});












