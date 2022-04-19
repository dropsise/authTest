import { logoutUser, loggedInCheck } from './user.js'

// l'utilisateur de la session
var user = null;

const home = document.querySelector('.home')
const logoutBtn = home.querySelector('.logout .btn')
const user_name = home.querySelector('.name')
const user_email = home.querySelector('.email')
const user_birthday = home.querySelector('.birthday')
// const user_online = home.querySelector('.online')
const user_img = home.querySelector('.img')

/**
 * verifie si un utilisateur est déjà connecté
 */
window.onload = async () => {
    const data = await loggedInCheck()
    if (data && data.success) {
        setUser(data.user)
        setUserProfile()
    } else {
        window.location.href = '../index.html'
    }
}

logoutBtn.onclick = handleLogout

/**
 * Affiche les informaton de l'utilisateur
 */
function setUserProfile() {
    user_img.src = `../assets/icons/${user.gender>0 ? 'woman' : 'man'}.png`
    user_name.innerText = user.name
    user_email.innerText = user.email
    user_birthday.innerText = 'né le ' + new Date(user.birthday).toLocaleDateString()
    // user_online.innerText = user.online>0 ? 'online' : 'offline'
}

/**
 * Deconnexion de l'utilisateur
 */
async function handleLogout() {
    await logoutUser()
    window.location.href = '../index.html'
}

/**
 * met à jour les données de l'utilisateur
 * @param {object} data 
 */
function setUser(data) {
    user = data;
    console.log(user)
}