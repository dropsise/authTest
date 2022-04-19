function isValidateEmail(value) {
  let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return re.test(String(value).toLowerCase())
};

function isValidateName(value) {
  let re = /[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/
  return !re.test(value)
}

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