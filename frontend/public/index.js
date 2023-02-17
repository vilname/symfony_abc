const form = document.calculatePriceAndQuantity;

form.onsubmit = function (event) {
    event.preventDefault();

    let formItem = {};

    const data = new FormData(event.target);
    for (const [key, value] of data) {
        formItem[key] = value;
    }

    fetch("http://localhost:8081/api/v1/calculate-price-and-quantity", {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formItem)
    })
        .then( (response) => {
            return response.json();
        })
        .then((data) => {
            let productHtml = '';
            data.products.forEach((product) => {
                productHtml += `
                    <div class="row">
                        <div class="col-1 border">${product.id}</div>
                        <div class="col-2 border">${product.name}</div>
                        <div class="col-2 border">${product.price}</div>
                        <div class="col-2 border">${product.quantity}</div>
                        <div class="col-2 border">${product.date}</div>
                    </div>
                `;
            })

            document.querySelector('.js-content-product').innerHTML = productHtml;

            let productStorkHtml = '';
            for (const [key, product] of Object.entries(data.productsStock)) {
                productStorkHtml += `
                    <div class="row">
                        <div class="col-2 border">${product.name}</div>
                        <div class="col-2 border">${product.quantity}</div>
                    </div>
                `;
            }

            document.querySelector('.js-content-product-stock').innerHTML = productStorkHtml;

            console.log('data', data)
        });
}
