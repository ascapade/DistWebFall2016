var btnSignIn = document.getElementById("btnSignIn");
btnSignIn.onclick = logout();

function logout(){
	if(btnSignIn.value = "Sign Out"){
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
					if(xmlhttp.responseText != "error")
					{
						callback(xmlhttp.responseText);
					}
				}
			}
		}
		xmlhttp.open("GET", "./php/logout.php", true);
		xmlhttp.send();
	}
}

function callback(reply){
	var btnSignIn = document.getElementById("btnSignIn");
	var username = document.getElementById("loggedInUser");
	
	btnSignIn.innerHTML = "Sign In";
	btnSignIn.value = "Sign In";
	username.innerHTML = "";
}