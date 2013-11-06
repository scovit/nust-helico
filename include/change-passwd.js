function set_usererror(text) {
    var newTag = document.getElementById("usererror");
    newTag.innerHTML = text;
}

function passwd(event) {
    
    var passwdRequest = new XMLHttpRequest();
    var params = "action=passwd" +
        "&oldpwd=" +
        document.forms["passwdform"]["oldpwd"].value +
        "&newpwd=" +
        document.forms["passwdform"]["newpwd"].value;


    passwdRequest.open("POST", webdir + "/admin/user.php", true);

    passwdRequest.setRequestHeader("Content-type",
                                  "application/x-www-form-urlencoded");
    passwdRequest.setRequestHeader("Content-length",
                                  params.length);
    passwdRequest.setRequestHeader("Connection",
                                  "close");

    passwdRequest.onreadystatechange = function () {
        if (passwdRequest.readyState==4) {
//          alert(passwdRequest.responseText);
            if (passwdRequest.responseText === "&end") {
                set_usererror("Changing password..");
                window.location.href = "..";
            } else if (passwdRequest.responseText === "&error 2")
                set_usererror("Enter old and new password");
	    else if (passwdRequest.responseText === "&error 3")
                set_usererror("Wrong old password");
	    else if (passwdRequest.responseText === "&error 4")
                set_usererror("Password should not contain (&, \\, \", ', $) characters");   
            else if (passwdRequest.responseText === "&error 5")
                set_usererror("Internal error");
	}
    };

    passwdRequest.send(params);
}
