// start product_details page -> increase, decrease items 
var increaseBtn = document.getElementsByClassName('btn-increase');
var decreaseBtn = document.getElementsByClassName('btn-decrease');
var itemsToBuy = document.getElementById('num_of_items');
var itemPrice = document.getElementById('price-value');

// Assuming singleItemPrice is defined with the price of one item
var singleItemPrice = parseFloat(itemPrice.innerText);

function increaseValueBtn() {
    var quantity = Number(itemsToBuy.value) + 1;
    itemsToBuy.value = quantity;
    updatePrice(quantity);
}

function decreaseValueBtn() {
    var quantity = Number(itemsToBuy.value) - 1;
    quantity = quantity < 0 ? 0 : quantity;
    itemsToBuy.value = quantity;
    updatePrice(quantity);
}

function updatePrice(quantity) {
    itemPrice.innerText = (singleItemPrice * quantity).toFixed(2);
}

// Attach event listeners to buttons
for (let i = 0; i < increaseBtn.length; i++) {
    increaseBtn[i].addEventListener('click', increaseValueBtn);
    decreaseBtn[i].addEventListener('click', decreaseValueBtn);
}
// end product_details page -> increase, decrease items 
