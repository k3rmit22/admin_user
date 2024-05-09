    // JavaScript to set input border color based on PHP validation result
    window.onload = function() {
        var error_message = "<?php echo $error_message; ?>";
        var color_validation = "<?php echo $color_validation; ?>";

        if (error_message !== "") {
            var usernameInput = document.getElementById("username");
            var passwordInput = document.getElementById("password");
            var errorMessageElement = document.getElementById("error-message");
            
            errorMessageElement.style.color = color_validation;
            usernameInput.style.borderColor = color_validation;
            passwordInput.style.borderColor = color_validation;
        }
    };

    document.getElementById("email-form").addEventListener("submit", function() {
    // Disable the button to prevent multiple submissions
    document.getElementById("send-otp").disabled = true;
});


  // JavaScript function to toggle password visibility
  function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleIcon = document.querySelector(".toggle-password i"); // Updated selector

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}


    // Check if the user is already logged in
        if (sessionStorage.getItem("loggedIn")) {
            // If logged in, redirect to admin.php
            window.location.replace("admin.php");
        }

        // Form submission handling
        document.getElementById("login-form").addEventListener("submit", function (event) {
            // Set flag in sessionStorage to indicate user is logged in
            sessionStorage.setItem("loggedIn", "true");
        });