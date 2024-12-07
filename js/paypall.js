paypal.Buttons({
    createOrder: function(data, actions) {
        var totalValue = parseFloat(document.getElementById('total').textContent.replace(',', '.')).toFixed(2);

        return actions.order.create({
            purchase_units: [{
                amount: {
                    currency_code: "BRL",
                    value: totalValue
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        // Após a aprovação do pagamento
        return actions.order.capture().then(function(details) {
            alert('Pagamento realizado com sucesso por ' + details.payer.name.given_name);
        });
    }
}).render('#paypal-button-container'); 