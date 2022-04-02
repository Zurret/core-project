
// Add Class to Element
function addElementClass(id, className) {
  const element = document.getElementById(id)
  element.className += ' ' + className
}

// Remove Class from Element
function removeElementClass(id, className) {
  const element = document.getElementById(id)
  element.className = element.className.replace(className, '')
}

// E-Mail Validation
function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return re.test(email)
}

// Generate Random Password
function generatePassword() {
  const length = 12
  const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-#@$!%*?&'
  let retVal = ''
  for (let i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n))
  }
  return retVal
}

// Check E-Mail and Password Length
function checkLoginInputs() {
  const email = document.getElementById('email')
  const password = document.getElementById('password')
  let emailValid = false
  let passwordValid = false

  if (email.value.length > 0 && validateEmail(email.value)) {
    removeElementClass('email', 'invalid')
    emailValid = true
  } else {
    addElementClass('email', 'invalid')
  }
  if (password.value.length > 0) {
    removeElementClass('password', 'invalid')
    passwordValid = true
  } else {
    addElementClass('password', 'invalid')
  }

  document.getElementById('login-button').disabled = !(emailValid && passwordValid);
}

// Check E-Mail, Password and Password Confirmation Length
function checkRegisterInputs() {
  const email = document.getElementById('email')
  const password = document.getElementById('password')
  const passwordConfirmation = document.getElementById('password_confirm')
  let emailValid = false
  let passwordValid = false
  let passwordConfirmationValid = false

  if (email.value.length > 0 && validateEmail(email.value)) {
    removeElementClass('email', 'invalid')
    emailValid = true
  } else {
    addElementClass('email', 'invalid')
  }
  if (password.value.length > 0) {
    removeElementClass('password', 'invalid')
    passwordValid = true
  } else {
    addElementClass('password', 'invalid')
  }
  if (passwordConfirmation.value.length > 0 && passwordConfirmation.value === password.value) {
    removeElementClass('password_confirm', 'invalid')
    passwordConfirmationValid = true
  } else {
    addElementClass('password_confirm', 'invalid')
  }

  document.getElementById('register-button').disabled = !(emailValid && passwordValid && passwordConfirmationValid);
}

// Password Visibility
function togglePasswordVisibility() {
  const password = document.getElementById('password')
  const passwordVisibility = document.getElementById('password-visibility')
  if (password.type === 'password') {
    password.type = 'text'
    passwordVisibility.innerHTML = 'Hide'
  } else {
    password.type = 'password'
    passwordVisibility.innerHTML = 'Show'
  }
}

// Set generated password
function setGeneratedPassword() {
  const password = document.getElementById('password')
  const passwordVisibility = document.getElementById('password-visibility')
  password.value = generatePassword()
  if (password.type === 'password') {
    password.type = 'text'
    passwordVisibility.innerHTML = 'Hide'
  }
}
