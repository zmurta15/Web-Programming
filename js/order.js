window.addEventListener('load', function() {
    'use strict';

    let l_total = 0;
    let l_delivery = 0;
    const l_form = document.getElementById('orderForm');
    l_form.total.value = '0.00';

    /*Function to calculate the total price of the toys including the delivery price */
    l_form.addEventListener("click", function() {
        l_total = 0;
        l_delivery = 0;
        const l_items = l_form.querySelectorAll('div.item');
        
        for(let i=0; i<l_items.length; i++) {
            const t_checkbox = l_items[i].querySelector('input[data-price][type=checkbox]');
            if(t_checkbox.checked) {
                l_total += parseFloat(t_checkbox.dataset.price);
            }
        }
        const l_radius = l_form.querySelectorAll('input[name=deliveryType]');
        for(let i =0; i< l_radius.length ; i++) {
            if(l_radius[i].checked) {
                l_delivery += parseFloat(l_radius[i].dataset.price);
            }
        }
        let final = 0;
        if(l_total == 0) {
            l_form.total.value = '0.00';
        }
        else {
            final = l_total + l_delivery;
            l_form.total.value = final.toFixed(2);
        }
        
    });

    /*Function to the style of terms and conditions when checkbox is checked*/
    l_form.termsChkbx.addEventListener("click", function() {
        const terms = document.getElementById('termsText');
        const sub = document.getElementById('placeOrder').querySelector('input[type=submit]');
        if(l_form.termsChkbx.checked == false) {
            terms.style.color = "#FF0000";
            terms.style.fontWeight = "bold";
            sub.disabled = true;
        }
        else {
            terms.style.color = "black";
            terms.style.fontWeight = "normal";
            sub.disabled = false;
        }
    });

    /*Function to check the values inserted on the form */
    l_form.submit.addEventListener("click", function(_evt){
        let l_failed = false;
        if(l_form.forename.value == false) {
            alert("Please add a forename");
            l_failed = true;
        }
        else if(l_form.surname.value == false) {
            alert("Please add a surname");
            l_failed = true;
        }
        else if (l_total == 0) {
            alert("Please add at least one product");
            l_failed = true
        }
        if(l_failed) {
            _evt.preventDefault();
        }
    });

});