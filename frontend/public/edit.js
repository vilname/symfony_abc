const urlParams = new URLSearchParams(window.location.search);
const userId = urlParams.get('userId');

document.querySelector('[name="id"]').value = userId;

fetch("http://localhost:8081/api/v1/score/edit/" + userId, {
    method: "get"
})
    .then( (response) => {
        return response.json();
    })
    .then(function(json) {

        document.querySelectorAll('input').forEach((item) => {
            if (json[item.name]) {
                item.value = json[item.name]
            }
        })

        document.querySelectorAll('#educationType option').forEach((item) => {
            if (item.textContent === json.educationName) {
                item.selected = true;
            }
        })

        const agreement = document.querySelector('#agreement');
        if (json.agreement) {
            agreement.checked = true;
        }

        let score = json.score;
        let html = `<li class="list-group-item">Скоринг телефона: ${score.phoneScore}</li>`
        html += `<li class="list-group-item">Скоринг почты: ${score.emailScore}</li>`
        html += `<li class="list-group-item">Скоринг образования: ${score.educationScore}</li>`
        html += `<li class="list-group-item">Скоринг согласия: ${score.agreementScore}</li>`
        html += `<li class="list-group-item">Скоринг всего: ${score.totalScore}</li>`

        document.querySelector('.js-scoring').innerHTML = html;
    })

const form = document.editUser;

form.onsubmit = function (event) {
    event.preventDefault();

    let formItem = {};

    const data = new FormData(event.target);
    for (const [key, value] of data) {
        formItem[key] = value;
    }

    fetch("http://localhost:8081/api/v1/user/save", {
        method: "post",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },

        //make sure to serialize your JSON body
        body: JSON.stringify(formItem)
    })
        .then( (response) => {
            console.log('response', response);
        });
}
