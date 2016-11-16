function incrementValue()
{
    var cartTotal = document.getElementById('cartTotal');
	var number = cartTotal.innerHTML;
	number++;
	cartTotal.innerHTML = number;
}