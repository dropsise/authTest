import utils from "./utils.js"
import { loginUser, loggedInCheck } from './user.js'

// Les données de l'utilisateur
var userInfo = {
    email: '',
    password: '',
}

var login = document.querySelector('.login')
var loginForm = login.querySelector('.form')
var inputField = login.querySelectorAll('.field .input')

/**
 * Verifie si un utilisateur est déja authentifié
 */
window.onload = async () => {
    const data = await loggedInCheck()
    if (data && data.success) {
        window.location.href = '../home.html'
    }
}

//
loginForm.onsubmit = handlerSubmit
//
inputField.forEach(e => e.onkeyup = handleChange)

/**
 * 
 * @param {HTMLElement} e 
 */
async function handlerSubmit(e) {
    e.preventDefault();
    if (isEnableSignIn()) {
        const data = await loginUser(userInfo)
        if (data.success) {
            localStorage.setItem('loginToken', data.token)
            window.location.href = '../home.html'
        }
    }
}


/**
 * 
 * @param {HTMLElement} e 
 */
function handleChange(e) {
    // update user info
    setUserInfo({
        ...userInfo,
        [e.target.name]: e.target.value,
    })
}

/**
 * Vérifie si les informations de l'utilisateur sont valides
 * @returns {boolean}
 */
 function isEnableSignIn() {
    const {
        email,
        password,
    } = userInfo

    return email && password && utils.isValidateEmail(email) && utils.isValidatePassword(password)
}

/**
 * Met à jour les données de l'utilisateur
 * @param {object} data 
 */
function setUserInfo(data) {
    userInfo = data
};