import { logoutUser, loggedInCheck } from './user.js'

var user = null;

const home = document.querySelector('.home')
const logoutBtn = home.querySelector('.logout .btn')
const user_name = home.querySelector('.name')
const user_email = home.querySelector('.email')
const user_birthday = home.querySelector('.birthday')
const user_online = home.querySelector('.online')
const user_img = home.querySelector('.img')


window.onload = async () => {
    const data = await loggedInCheck()
    if (data && data.success) {
        setUser(data.user)
        setUserProfile()
    } else {
        window.location.href = '../index.html'
    }
}

function setUserProfile() {
    user_img.src = `../assets/icons/${user.gender>0 ? 'woman' : 'man'}.png`
    user_name.innerText = user.name
    user_email.innerText = user.email
    user_birthday.innerText = 'né le ' + new Date(user.birthday).toLocaleDateString()
    // user_online.innerText = user.online>0 ? 'online' : 'offline'
}


logoutBtn.onclick = handleLogout



async function handleLogout() {
    await logoutUser()
    window.location.href = '../index.html'
}


function setUser(data) {
    user = data;
    console.log(user)
}