
// Add Class to Element
function addElementClass(id, className) {
    var element = document.getElementById(id);
    element.className += " " + className;
}

// Remove Class from Element
function removeElementClass(id, className) {
    var element = document.getElementById(id);
    element.className = element.className.replace(className, "");
}

// E-Mail Validation
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

// Generate Random Password
function generatePassword() {
    var length = 12,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-#@$!%*?&",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

// Check E-Mail and Password Length
function checkLoginInputs() {
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var emailValid = false;
    var passwordValid = false;

    if (email.value.length > 0 && validateEmail(email.value)) {
        removeElementClass("email", "invalid");
        emailValid = true;
    } else {
        addElementClass("email", "invalid");
    }
    if (password.value.length > 0) {
        removeElementClass("password", "invalid");
        passwordValid = true;
    } else {
        addElementClass("password", "invalid");
    }

    if (emailValid && passwordValid) {
        document.getElementById("login-button").disabled = false;
    } else {
        document.getElementById("login-button").disabled = true;
    }
}

// Check E-Mail, Password and Password Confirmation Length
function checkRegisterInputs() {
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var passwordConfirmation = document.getElementById("password_confirm");
    var emailValid = false;
    var passwordValid = false;
    var passwordConfirmationValid = false;

    if (email.value.length > 0 && validateEmail(email.value)) {
        removeElementClass("email", "invalid");
        emailValid = true;
    } else {
        addElementClass("email", "invalid");
    }
    if (password.value.length > 0) {
        removeElementClass("password", "invalid");
        passwordValid = true;
    } else {
        addElementClass("password", "invalid");
    }
    if (passwordConfirmation.value.length > 0 && passwordConfirmation.value == password.value) {
        removeElementClass("password_confirm", "invalid");
        passwordConfirmationValid = true;
    } else {
        addElementClass("password_confirm", "invalid");
    }

    if (emailValid && passwordValid && passwordConfirmationValid) {
        document.getElementById("register-button").disabled = false;
    } else {
        document.getElementById("register-button").disabled = true;
    }
}

// Password Visibility
function togglePasswordVisibility() {
    var password = document.getElementById("password");
    var passwordVisibility = document.getElementById("password-visibility");
    if (password.type == "password") {
        password.type = "text";
        passwordVisibility.innerHTML = "Hide";
    } else {
        password.type = "password";
        passwordVisibility.innerHTML = "Show";
    }
}

// Set generated password
function setGeneratedPassword() {
    var password = document.getElementById("password");
    var passwordVisibility = document.getElementById("password-visibility");
    password.value = generatePassword();
    if (password.type == "password") {
        password.type = "text";
        passwordVisibility.innerHTML = "Hide";
    }
}

// Generate a popup window using an existing div
function generatePopup(title, content) {
    var popup = document.getElementById("overDiv");
    // Set popup title
    popup.innerHTML = '<div class="popup-title">' + title + ' <span class="popup-close">[<span class="popup-cross" onclick="closePopup();">X</span>]</span></div><div class="popup-content">' + content + '</div>';
    // Get popup window dimensions
    var popupHeight = popup.offsetHeight;
    var popupWidth = popup.offsetWidth;
    // Position the popup window over mouse cursor
    popup.style.top = (window.event.y)-(popupHeight/2) + 'px';
    popup.style.left = (window.event.x)-(popupWidth/2) + 'px';
    // Show the popup window
    popup.style.display = 'block';
    popup.style.visibility = 'visible';
    // Move the popup window with click
    popup.addEventListener('mousedown', function(e) {
        popup.style.cursor = 'move';
        isDown = true;
        offset = [
            popup.offsetLeft - e.clientX,
            popup.offsetTop - e.clientY
        ];
    }, true);
    popup.addEventListener('mouseup', function() {
        popup.style.cursor = 'default';
        isDown = false;
    }, true);
    popup.addEventListener('mousemove', function(event) {
        event.preventDefault();
        if (isDown) {
            mousePosition = {
                x : event.clientX,
                y : event.clientY,
            };
            // Lock Mouse Cursor to Popup Window while moving
            // Move the popup window
            popup.style.left = (mousePosition.x + offset[0]) + 'px';
            popup.style.top  = (mousePosition.y + offset[1]) + 'px';
            // Don't move the window out of the screen
            if (popup.offsetLeft < 0) {
                popup.style.left = '0px';
            }
            if (popup.offsetTop < 0) {
                popup.style.top = '0px';
            }
            if (popup.offsetLeft + popupWidth > window.innerWidth) {
                popup.style.left = (window.innerWidth - popupWidth) + 'px';
            }
            if (popup.offsetTop + popupHeight > window.innerHeight) {
                popup.style.top = (window.innerHeight - popupHeight) + 'px';
            }
        }
            
    }, true);
}

// Close the popup window
function closePopup() {
    var popup = document.getElementById("overDiv");
    popup.style.display = 'none';
    popup.style.visibility = 'hidden';
}
