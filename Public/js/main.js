    
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

    // Check E-Mail and Password Length
    function checkInputs() {
        var email = document.getElementById("email");
        var password = document.getElementById("password");
        var emailValid = false;
        var passwordValid = false;

        if (email.value.length > 0 && email.value.indexOf("@") > 0) {
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
