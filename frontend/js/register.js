import utils from './Utils.js'
import { registerUser, loggedInCheck } from './user.js'

var userInfo = {
    firstname: '',
    lastname: '',
    email: '',
    email_check: '',
    password: '',

    birthday: null,
    gender: null
}

var register = document.querySelector('.register')
var registerForm = register.querySelector('.form')
var inputField = register.querySelectorAll('.field .input')
var gender = register.querySelectorAll('.gender_section .gender')
var birthday = register.querySelector('.input[name="birthday"]')

// Verifie si un utilisateur est déja authentifié
window.onload = async () => {
    const data = await loggedInCheck()
    if (data && data.success) {
        window.location.href = '../home.html'
    }
}

//
registerForm.onsubmit = handlerSubmit

//
inputField.forEach(e => e.onkeyup = handleChange)

// La date de naissance de l'utilisateur
birthday.onchange = handlerBirthDayChange

// Le genre de l'utilisateur (Homme / Femme)
gender.forEach(e => e.onclick = handlerMyRadioClick)

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
 * 
 * @param {HTMLElement} e 
 */
function handlerBirthDayChange(e) {
    setUserInfo({
        ...userInfo,
        birthday: new Date(e.target.value).getTime()
    })
    //console.log(userInfo.birthday)
}

/**
 * 
 * @param {HTMLElement} e 
 */
function handlerMyRadioClick(e) {
    setUserInfo({
        ...userInfo,
        gender: parseInt(e.target.value)
    })
}

/**
 * 
 * @param {HTMLElement} e 
 */
async function handlerSubmit(e) {
    e.preventDefault();
    if (isEnableSignIn()) {
        const data = await registerUser(userInfo)
        if (data.success) {
            localStorage.setItem('loginToken', data.token)
            window.location.href = '../home.html'
        }
    }
}

/**
 * 
 * @returns {boolean}
 */
 function isEnableSignIn() {
    const {
        firstname,
        lastname,
        email,
        email_check,
        password,
    
        birthday,
        gender,
    } = userInfo

    // check empty field
    if (firstname && lastname && email && email_check && password && birthday && gender>=0) {
        // check validation
        if (utils.isValidateName(firstname) && utils.isValidateName(lastname) && utils.isValidateEmail(email) && utils.isValidatePassword(password)) {
            // check email comfirmation
            if (email === email_check) {
                return true
            }
        }
    }
    return false
}


/**
 * 
 * @param {object} data 
 */
 function setUserInfo(data) {
    userInfo = data
    //console.log(userInfo)
};