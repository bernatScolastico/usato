const wrapper = document.querySelector('.wrapper');
const registerLink = document.querySelector('.register-link');
const loginLink = document.querySelector('.login-link');

registerLink.onclick = () => {
    wrapper.classList.add('active');
}

loginLink.onclick = () => {
    wrapper.classList.remove('active');
}


// Attendi 5 secondi (5000 millisecondi) e poi rimuovi il div
setTimeout(function() {
    var div = document.getElementById('furbacchione');
    if (div) {
        div.parentNode.removeChild(div);
    }
}, 5000);
