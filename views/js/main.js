
const msg = document.querySelector('.msg')

/**
 * Afficher un message à l'utilisateur au chargement de la page. 
 */
window.onload = function() {
    if (msg.innerText) {
        alert(msg.innerText)
    }
}
