import Choices from "choices.js";

const clientSelect = document.getElementById('client_id');
if(clientSelect) {
    const clientSelected = clientSelect.getAttribute('data-old-choice');
    const clientChoices = new Choices('#client_id', {
        i18n: {
            noResults: 'Nenhum resultado encontrado',
            noChoices: 'Sem opções disponíveis',
            itemSelectText: 'Clique para selecionar',
        }
    });

    fetch('/sales/getClientOptions')
        .then(response => response.json())
        .then(data => {
            const dataArray = Object.entries(data).map(([value, label]) => ({ value, label }));
            clientChoices.setChoices(dataArray, 'value', 'label', true);

            if(clientSelected) clientChoices.setChoiceByValue(clientSelected);
        });
}

const paymentSelect = document.getElementById('payment_method_id');
if(paymentSelect) {
    const paymentSelected = paymentSelect.getAttribute('data-old-choice');
    const paymentChoices = new Choices('#payment_method_id', {
        i18n: {
            noResults: 'Nenhum resultado encontrado',
            noChoices: 'Sem opções disponíveis',
            itemSelectText: 'Clique para selecionar',
        }
    });

    fetch('/sales/getPaymentMethodOptions')
        .then(response => response.json())
        .then(data => {
            const dataArray = Object.entries(data).map(([value, label]) => ({ value, label }));
            paymentChoices.setChoices(dataArray, 'value', 'label', true);

            if(paymentSelected) paymentChoices.setChoiceByValue(paymentSelected);
        });
}

const productSelect = document.getElementById('product_id');
if(productSelect) {
    const productSelected = productSelect.getAttribute('data-old-choice');
    const productChoices = new Choices('#product_id', {
        i18n: {
            noResults: 'Nenhum resultado encontrado',
            noChoices: 'Sem opções disponíveis',
            itemSelectText: 'Clique para selecionar',
        }
    });

    fetch('/sales/getProductsOptions')
        .then(response => response.json())
        .then(data => {
            const dataArray = Object.entries(data).map(([value, label]) => ({ value, label }));
            productChoices.setChoices(dataArray, 'value', 'label', true);

            if(productSelected) productChoices.setChoiceByValue(productSelected);
        });
}
