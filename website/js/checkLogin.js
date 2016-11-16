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
				Console.log(xmlhttp.responseText);
				changeHTML(xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("GET", "./php/checkLogin.php", true);
	xmlhttp.send();
}

function changeHTML(user){
	var btnSignIn = document.getElementById("btnSignIn");
	var username = document.getElementById("loggedInUser");
	if(user != "")
	{
		btnSignIn.innerHTML = "Sign Out";
		btnSignIn.value = "Sign Out";
		username.innerHTML = "Hello " + user;
	}
	else
	{
		btnSignIn.innerHTML = "Sign In";
		btnSignIn.value = "Sign In";
		username.innerHTML = "Not signed in";
	}
}

window.onload = check();