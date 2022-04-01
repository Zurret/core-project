
// Add Class to Element
function addElementClass (id, className) {
  const element = document.getElementById(id)
  element.className += ' ' + className
}

// Remove Class from Element
function removeElementClass (id, className) {
  const element = document.getElementById(id)
  element.className = element.className.replace(className, '')
}

// E-Mail Validation
function validateEmail (email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return re.test(email)
}

// Generate Random Password
function generatePassword () {
  const length = 12
  const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-#@$!%*?&'
  let retVal = ''
  for (let i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n))
  }
  return retVal
}

// Check E-Mail and Password Length
function checkLoginInputs () {
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

  if (emailValid && passwordValid) {
    document.getElementById('login-button').disabled = false
  } else {
    document.getElementById('login-button').disabled = true
  }
}

// Check E-Mail, Password and Password Confirmation Length
function checkRegisterInputs () {
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
  if (passwordConfirmation.value.length > 0 && passwordConfirmation.value == password.value) {
    removeElementClass('password_confirm', 'invalid')
    passwordConfirmationValid = true
  } else {
    addElementClass('password_confirm', 'invalid')
  }

  if (emailValid && passwordValid && passwordConfirmationValid) {
    document.getElementById('register-button').disabled = false
  } else {
    document.getElementById('register-button').disabled = true
  }
}

// Password Visibility
function togglePasswordVisibility () {
  const password = document.getElementById('password')
  const passwordVisibility = document.getElementById('password-visibility')
  if (password.type == 'password') {
    password.type = 'text'
    passwordVisibility.innerHTML = 'Hide'
  } else {
    password.type = 'password'
    passwordVisibility.innerHTML = 'Show'
  }
}

// Set generated password
function setGeneratedPassword () {
  const password = document.getElementById('password')
  const passwordVisibility = document.getElementById('password-visibility')
  password.value = generatePassword()
  if (password.type == 'password') {
    password.type = 'text'
    passwordVisibility.innerHTML = 'Hide'
  }
}

// Generate a popup window using an existing div
function generatePopup (title, content) {
  const titleHtml = title.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')
  const contentHtml = content.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')
  const popupIdName = 'overDiv'
  // If Title OR Content is empty, return
  if (titleHtml == '' || contentHtml == '') {
    return
  }
  // If popupIdName div already exists, remove it
  if (document.getElementById(popupIdName)) {
    document.getElementById(popupIdName).remove()
  }
  // Create Popup
  const popup = document.createElement('div')
  // Set Div id
  popup.id = popupIdName
  document.body.appendChild(popup)
  // remove iframe and script html elements from title and content
  // set popup title and content
  popup.innerHTML = '<div id="popup-title"></div><div id="popup-content"></div>'
  let isDown = false
  const popupTitle = document.getElementById('popup-title')
  const popupContent = document.getElementById('popup-content')
  popupTitle.innerHTML = titleHtml + ' <span class="popup-close">[<span class="popup-cross">X</span>]</span>'
  popupContent.innerHTML = contentHtml
  // Get popup window dimensions
  const popupHeight = popup.offsetHeight
  const popupWidth = popup.offsetWidth
  // Position the popup window over mouse cursor
  popup.style.top = (window.event.y) - (popupHeight / 2) + 'px'
  popup.style.left = (window.event.x) - (popupWidth / 2) + 'px'
  // Show the popup window
  popup.style.display = 'block'
  popup.style.visibility = 'visible'
  // Move the popup window with click
  popupTitle.addEventListener('mousedown', function (e) {
    popup.style.cursor = 'move'
    isDown = true
    offset = [
      popup.offsetLeft - e.clientX,
      popup.offsetTop - e.clientY
    ]
  }, true)
  popupTitle.addEventListener('mouseup', function () {
    popup.style.cursor = 'default'
    isDown = false
  }, true)
  popup.addEventListener('mousemove', function (event) {
    event.preventDefault()
    if (isDown) {
      mousePosition = {
        x: event.clientX,
        y: event.clientY
      }
      // Fix mouse position if it goes out of the window
      if (mousePosition.x < 0) {
        mousePosition.x = 0
      }
      if (mousePosition.y < 0) {
        mousePosition.y = 0
      }
      if (mousePosition.x > window.innerWidth) {
        mousePosition.x = window.innerWidth
      }
      if (mousePosition.y > window.innerHeight) {
        mousePosition.y = window.innerHeight
      }
      // Move the popup window
      popup.style.left = (mousePosition.x + offset[0]) + 'px'
      popup.style.top = (mousePosition.y + offset[1]) + 'px'
      // Don't move the window out of the screen
      if (popup.offsetLeft < 0) {
        popup.style.left = '0px'
      }
      if (popup.offsetTop < 0) {
        popup.style.top = '0px'
      }
      if (popup.offsetLeft + popupWidth > window.innerWidth) {
        popup.style.left = (window.innerWidth - popupWidth) + 'px'
      }
      if (popup.offsetTop + popupHeight > window.innerHeight) {
        popup.style.top = (window.innerHeight - popupHeight) + 'px'
      }
    }
  }, true)
  // Close Popup Window if clicked on the cross
  popup.addEventListener('click', function (e) {
    if (e.target.className === 'popup-cross') {
      popup.style.display = 'none'
      popup.style.visibility = 'hidden'
    }
  }, true)
}
