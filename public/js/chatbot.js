document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('#chatbot-form');
    var input = document.querySelector('#chatbot-question');
    var responseBox = document.querySelector('#chatbot-response');

    if (!form || !input || !responseBox) {
        return;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var question = input.value.trim();
        if (!question) {
            responseBox.textContent = 'Veuillez saisir une question.';
            return;
        }

        responseBox.textContent = 'Recherche de réponse...';

        fetch('/chatbot-api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ question: question })
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    responseBox.textContent = data.answer;
                } else {
                    responseBox.textContent = data.message || 'Impossible de récupérer la réponse.';
                }
            })
            .catch(function () {
                responseBox.textContent = 'Erreur lors de la connexion au chatbot. Réessayez plus tard.';
            });
    });
});
