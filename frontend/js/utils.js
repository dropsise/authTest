/**
 * Vérifie le format d'un email
 * @param {*} value 
 * @returns {boolean}
 */
function isValidateEmail(value) {
  let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return re.test(String(value).toLowerCase())
};

/**
 * Vérifie qu'une chaine est alphabétique
 * @param {string} value 
 * @returns {boolean}
 */
function isValidateName(value) {
  let re = /[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/
  return !re.test(value)
}

/**
 * Vérifie que la longueur d'un mot de passe est supérieur à 4 caractères 
 * @param {string} value 
 * @returns {boolean}
 */
function isValidatePassword(value) {
  let re = /.{4,}$/
  return re.test(value)
}

const utils = {
  isValidateEmail,
  isValidateName,
  isValidatePassword,
};

export default utils;