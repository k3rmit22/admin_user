document.addEventListener("DOMContentLoaded", function() {
    const logoutModal = document.getElementById("logoutModal");
    const confirmLogoutBtn = document.getElementById("confirmLogout");

    // Open the logout modal
    function openModal() {
        logoutModal.style.display = "block";
    }

    // Close the logout modal
    function closeModal() {
        logoutModal.style.display = "none";
    }

    // Event listener for logout icon click
    document.getElementById("logout-icon").addEventListener("click", openModal);

    // Event listener for close button click
    document.querySelector(".close").addEventListener("click", closeModal);

    // Event listener for cancel logout button click
    document.getElementById("cancelLogout").addEventListener("click", closeModal);

    // Event listener for confirm logout button click
    confirmLogoutBtn.addEventListener("click", function() {
        // Redirect to login.php
        window.location.href = "login.php";
    });
});
