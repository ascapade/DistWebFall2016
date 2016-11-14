function check(){
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			if(xmlhttp.responseText != "false")
			{
				changeHTML(xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("GET", "../php/checkLogin.php", true);
	xmlhttp.send();
}

function changeHTML(user){
	var btnSignIn = document.getElementById("btnSignIn");
	var username = document.getElementById("loggedInUser");
	
	btnSignIn.style.display = "none";
	username.style.display = "block";
	username.innerHTML = user;
}

window.onload = check();