
function set_usererror(text) {
    var newTag = document.getElementById("usererror");
    if (!newTag) {
	var box = document.getElementById("login-panel");
	newTag = document.createElement("p");
	newTag.innerHTML = text;
	newTag.id = "usererror";
	box.appendChild(newTag);
    } else {
	newTag.innerHTML = text;
    }
}

function login(event) {
    var loginRequest = new XMLHttpRequest();
    var params = "action=login" +
	"&username=" +
	document.forms["loginform"]["username"].value +
	"&password=" +
	document.forms["loginform"]["password"].value;


    loginRequest.open("POST", webdir + "/admin/user.php", true);

    loginRequest.setRequestHeader("Content-type",
				  "application/x-www-form-urlencoded");
    loginRequest.setRequestHeader("Content-length",
				  params.length);
    loginRequest.setRequestHeader("Connection",
				  "close");

    loginRequest.onreadystatechange = function () {
	if (loginRequest.readyState==4) {
//	    alert(loginRequest.responseText);
	    if (loginRequest.responseText === "&end") {
		set_usererror("Logging in..");
		window.location.reload();
	    } else if (loginRequest.responseText === "&notfound")
		set_usererror("Username or password is wrong");
	    else if (loginRequest.responseText === "&error 2")
		set_usererror("Enter username and password");
	}
    };

    loginRequest.send(params);
}
