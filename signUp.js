const DoiTT = document.getElementById('DoiTT');

ShowForm();

function ShowForm() {
    DoiTT.innerHTML = '';
    
    var form = document.createElement('form');
    form.action = 'signup.php';
    form.method = 'POST';
    form.setAttribute('style', 'width: 350px; align-items: center;border: 1px solid #ddd;padding: 2rem;background: #ffffff;');
    
    var pp = document.createElement('h3');
    pp.appendChild(document.createTextNode('Dien thong tin dang ki'));
    form.appendChild(pp);
    pp.setAttribute('style',' text-align: center;');
    form.innerHTML += '</br>';
    
    var ava = document.createElement('img');
    ava.setAttribute('src','source/Face.png');
    ava.id = "ChangeAvatar";
    form.appendChild(ava);
    ava.setAttribute('style','width: 120p; height: 120px; margin-left: 30%;border-radius: 50%;');
    
    var ChonImg = document.createElement('input');
    ChonImg.setAttribute('type', 'button');
    ChonImg.value = 'Select a photo';
    ChonImg.id = 'ChonAnh';
    form.appendChild(ChonImg);
    ChonImg.setAttribute('style', 'background: #69d2e7;border: 1px solid #ddd;color: #ffffff;margin-top: 20px; margin-left: 25%;width: 50%; height: 30px;text-transform: uppercase;');
    form.innerHTML += '</br>';
    
    var upFile = document.createElement('input');
    upFile.setAttribute('type', 'file');
    upFile.setAttribute('accept', 'image/*');
    upFile.setAttribute('onchange', 'getAnh()');
    upFile.id = 'myfile';
    form.appendChild(upFile);
    upFile.setAttribute('style', 'background: #69d2e7;border: 1px solid #ddd;color: #ffffff;\n\
width: 0; height: 0;text-transform: uppercase;');
    
    var tenMoi = document.createElement('input');
    tenMoi.setAttribute('type', 'text');
    tenMoi.placeholder = ' Ho ten ...';
    tenMoi.name = 'tenDK';
    form.appendChild(tenMoi);
    tenMoi.setAttribute('style', 'background: #fafafa;border: 1px solid #eeeeee;margin-top: 10px; margin-left: 5px;\n\
    width: 100%; height: 25px;');
    form.innerHTML += '</br>';
    
    var mkMoi = document.createElement('input');
    mkMoi.setAttribute('type', 'text');
    mkMoi.placeholder = ' mat khau ...';
    mkMoi.name = 'passDK';
    form.appendChild(mkMoi);
    mkMoi.setAttribute('style', 'background: #fafafa;border: 1px solid #eeeeee;margin-top: 10px; margin-left: 5px;\n\
    width: 100%; height: 25px;');
    form.innerHTML += '</br>';
    
    var mkMoi = document.createElement('input');
    mkMoi.setAttribute('type', 'text');
    mkMoi.placeholder = ' so dien thoai...';
    mkMoi.name = 'soDtDK';
    form.appendChild(mkMoi);
    mkMoi.setAttribute('style', 'background: #fafafa;border: 1px solid #eeeeee;margin-top: 10px; margin-left: 5px;\n\
    width: 100%; height: 25px;');
    form.innerHTML += '</br>';
    
    var avaMoi = document.createElement('input');
    avaMoi.setAttribute('type', 'hidden');
    avaMoi.name = 'linkDK';
    avaMoi.id = 'avaMoi';
    form.appendChild(avaMoi);
    
    var doiMK = document.createElement('input');
    doiMK.setAttribute('type', 'submit');
    doiMK.value = 'Xac nhan';
    doiMK.name = 'do-register';
    form.appendChild(doiMK);
    doiMK.setAttribute('style', 'background: #69d2e7;border: 1px solid #ddd;color: #ffffff;margin-top: 20px; margin-left: 5px;width: 100%; height: 30px;text-transform: uppercase;');
    form.innerHTML += '</br>';
    
    var Huydi = document.createElement('input');
    Huydi.setAttribute('type', 'button');
    Huydi.value = 'Dang nhap';
    Huydi.id = 'Cancel';
    form.appendChild(Huydi);
    Huydi.setAttribute('style', 'background: #69d2e7;border: 1px solid #ddd;color: #ffffff;margin-top: 20px; margin-left: 25%;width: 50%; height: 30px;text-transform: uppercase;');
    form.innerHTML += '</br></br>';
    
    DoiTT.appendChild(form);
}

$(document).on('click', "#ChonAnh", function () {
    $('#myfile').click();
});

function getAnh(){
    const imgInput = document.getElementById('myfile');
    //console.log('ck');
    var dataU = "";
    
    if (imgInput.files && imgInput.files[0]) {
    var reader = new FileReader();
    reader.onload = function(){
        var src = reader.result;
	document.getElementById('ChangeAvatar').setAttribute('src', src);
        
        const dataText = document.createElement('TEXTAREA');
        dataText.innerText = src;	
        dataU = dataText.value;
        $('#avaMoi').val(dataU);
    };
    
    reader.readAsDataURL(imgInput.files[0]);
    }
}

$(document).on('click', "#Cancel", function () {
  window.location="login.php";
});
