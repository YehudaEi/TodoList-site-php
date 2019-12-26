function login(){
    user = document.getElementsByName('username')[0].value;
    pass = document.getElementsByName('password')[0].value;

    if(user == undefined || user == ""){
        UIkit.notification({
            message: "שם המשתמש ריק",
            pos: 'top-right'
        });
    }
    else if(pass == undefined || pass == ""){
        UIkit.notification({
            message: "הסיסמה ריקה",
            pos: 'top-right'
        });
    }
    else{
        $.post({
            type: "post",
            url: "?login",
            data: {'username': user, 'password': pass}
        }).then(data => {
            document.open();
            document.write(data);
            document.close();
            history.pushState(null, '', '?todo');
        });
    }
}

function register(){
    user = document.getElementsByName('username')[0].value;
    pass = document.getElementsByName('password')[0].value;
    pass2 = document.getElementsByName('password2')[0].value;

    if(user == undefined || user == ""){
        UIkit.notification({
            message: "שם המשתמש ריק",
            pos: 'top-right'
        });
    }
    else if(pass == undefined || pass == ""){
        UIkit.notification({
            message: "הסיסמה ריקה",
            pos: 'top-right'
        });
    }  
    else if(pass2 == undefined || pass2 == ""){
        UIkit.notification({
            message: "אימות הסיסמה ריק",
            pos: 'top-right'
        });
    }
    else{
        $.post({
            type: "post",
            url: "?register",
            data: {'username': user, 'password': pass, 'password2': pass2}
        }).then(data => {
            document.open();
            document.write(data);
            document.close();
            //history.pushState(null, '', '?login');
        });
    }
}

function loginToRegister(){
    $.get({
        type: "post",
        url: "?register",
    }).then(data => {
        document.open();
        document.write(data);
        document.close();
    });
    
    history.pushState(null, '', '?register');
}

function archiveToTodo(){
    $.get({
        type: "post",
        url: "?todo",
    }).then(data => {
        document.open();
        document.write(data);
        document.close();
    });
    
    history.pushState(null, '', '?todo');
}

function todoToArchive(){
    SaveMatalot();
    
    $.get({
        type: "post",
        url: "?archive",
    }).then(data => {
        document.open();
        document.write(data);
        document.close();
    });
    
    history.pushState(null, '', '?archive');
}

function registerToLogin(){
    $.get({
        type: "post",
        url: "?login",
    }).then(data => {
        document.open();
        document.write(data);
        document.close();
    });
    
    history.pushState(null, '', '?login');
}

function logout(){
    SaveMatalot();

    $.get({
        type: "post",
        url: "?logout",
    }).then(data => {
        document.open();
        document.write(data);
        document.close();
    });
    
    history.pushState(null, '', '?login');
}