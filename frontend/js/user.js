
const Axios = axios.create({
    baseURL: 'http://localhost/stage/backend/',
})

// On click on the Sign In button
async function loginUser(user) {
    // Sending the user Login request
    try {
        const {data} = await Axios.post('index.php?url=login', {
            email: user.email,
            password: user.password
        })
        return data
    } catch(err) {
        console.log(error)
    }
}

  // On click on the Sign Up button
async function registerUser(user) {
    try {
        // Sending the user registration request
        const {data} = await Axios.post('index.php?url=register', {
            firstname: String(user.firstname).toLowerCase(),
            lastname: String(user.lastname).toLowerCase(),
            email: user.email,
            password: user.password,
            birthday: user.birthday,
            gender: user.gender,
        })
        return data;
    } catch(err) {
        console.log(err)
    }
}

// On Click the Log out button
async function logoutUser() {
    try {
        const loginToken = localStorage.getItem('loginToken');
        //Adding JWT token to axios default header
        Axios.defaults.headers.common['Authorization'] = 'Bearer '+loginToken;
        // let's set user status `offline`
        await Axios.get('index.php?url=user/logout')
        // let's remove loginToken & user 
        localStorage.removeItem('loginToken');
    } catch(err) {
        console.log(error)
    }
}

// Checking user logged in or not
async function loggedInCheck() {
    try {
        const loginToken = localStorage.getItem('loginToken');
        // If inside the local-storage has the JWT token
        if (loginToken) {
            //Adding JWT token to axios default header
            Axios.defaults.headers.common['Authorization'] = 'Bearer '+loginToken;
            // Fetching the user information
            const {data} = await Axios.get('index.php?url=user')
            return data;
        }
    } catch(err) {
        console.log(error)
    }
}

export {
    registerUser,
    loginUser,
    logoutUser,
    loggedInCheck,
} 
