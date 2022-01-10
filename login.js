const DoiTT = document.getElementById('DoiTT');

ShowForm();

function ShowForm() {
    DoiTT.innerHTML = '';
    
    var form = document.createElement('div');
    form.setAttribute('style', 'width: 350px; align-items: center;border: 1px solid #ddd;padding: 2rem;background: #ffffff;');
    
    var pp = document.createElement('h3');
    pp.appendChild(document.createTextNode('Dang nhap'));
    form.appendChild(pp);
    pp.setAttribute('style',' text-align: center;');
    form.innerHTML += '</br>';
    
    var sodt = document.createElement('input');
    sodt.setAttribute('type', 'text');
    sodt.placeholder = ' so dien thoai...';
    sodt.id = 'soDT';
    form.appendChild(sodt);
    sodt.setAttribute('style', 'background: #fafafa;border: 1px solid #eeeeee;margin-top: 10px; margin-left: 5px;\n\
    width: 100%; height: 25px;');
    form.innerHTML += '</br>';
    
    var mkMoi = document.createElement('input');
    mkMoi.setAttribute('type', 'password');
    mkMoi.placeholder = ' mat khau ...';
    mkMoi.id = 'passDN';
    form.appendChild(mkMoi);
    mkMoi.setAttribute('style', 'background: #fafafa;border: 1px solid #eeeeee;margin-top: 10px; margin-left: 5px;\n\
    width: 100%; height: 25px;');
    form.innerHTML += '</br>';
    
    var doiMK = document.createElement('input');
    doiMK.setAttribute('type', 'button');
    doiMK.value = 'Dang nhap';
    doiMK.id = 'do_login';
    form.appendChild(doiMK);
    doiMK.setAttribute('style', 'background: #69d2e7;border: 1px solid #ddd;color: #ffffff;margin-top: 20px; margin-left: 5px;width: 100%; height: 30px;text-transform: uppercase;cursor: pointer;');
    form.innerHTML += '</br></br>';
    
    var pp2 = document.createElement('div');
    pp2.appendChild(document.createTextNode('Neu chua co tai khoan, hay '));
    form.appendChild(pp2);
    pp2.setAttribute('style',' text-align: center;');
    
    var aa = document.createElement('a');
    aa.appendChild(document.createTextNode('Dang ki'));
    pp2.appendChild(aa);
    aa.setAttribute('style',' text-align: center;cursor: pointer;');
    aa.setAttribute('href','signup.php');
    
    DoiTT.appendChild(form);
}

$(document).on('click', "#do_login", function () {
    var sod = $('#soDT').val();
    var mkk = $('#passDN').val();
 
    $.ajax({
        url:"login.php",
        method:"POST",
        data:{do_login: 1, soDT: sod, passDN: mkk},
        dataType:"JSON",
        
        success : function (result){
            console.log(result);
            var dc = result['code'];
            var mess = result['message'];
            if(dc == 1000){
                var tk = result["data"]["token"];
                sessionStorage.setItem("token", tk);
                
                var idd = result["data"]["id"];
                sessionStorage.setItem("user_id", idd);
                
                alert(mess);
                window.location="home.php";
            } else{
                alert(mess);
            }
        }
    });
});


