document.getElementById("login-form").addEventListener("submit", function(event) {
    var usernameInput = document.getElementById("username");
    var passwordInput = document.getElementById("password");
    var error_message = document.getElementById("error-message");
    var isValid = true;

    // Validate username
    if (usernameInput.value.trim() === "") {
        error_message.innerText = "Username is required";
        usernameInput.style.borderColor = "red"; // Set red border color
        isValid = false;
    } else {
        usernameInput.style.borderColor = "green"; // Set green border color
    }

    // Validate password
    if (passwordInput.value.trim() === "") {
        error_message.innerText = "Password is required";
        passwordInput.style.borderColor = "red"; // Set red border color
        isValid = false;
    } else {
        passwordInput.style.borderColor = "green"; // Set green border color
    }

    // Check if both fields are empty
    if (usernameInput.value.trim() === "" && passwordInput.value.trim() === "") {
        error_message.innerText = "Invalid username or password";
        isValid = false;
    }

    if (!isValid) {
        // Prevent form submission if validation fails
        event.preventDefault();
    }
});

document.getElementById("username").addEventListener("input", function() {
    var usernameInput = document.getElementById("username");
    var error_message = document.getElementById("error-message");

    if (usernameInput.value.trim() === "") {
        error_message.innerText = "Username is required";
        usernameInput.style.borderColor = "red"; // Set red border color
    } else {
        error_message.innerText = "";
        usernameInput.style.borderColor = "green"; // Set green border color
    }
});

document.getElementById("password").addEventListener("input", function() {
    var passwordInput = document.getElementById("password");
    var error_message = document.getElementById("error-message");

    if (passwordInput.value.trim() === "") {
        error_message.innerText = "Password is required";
        passwordInput.style.borderColor = "red"; // Set red border color
    } else {
        error_message.innerText = "";
        passwordInput.style.borderColor = "green"; // Set green border color
    }
});

