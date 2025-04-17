function togglePassword(fieldId, icon) {
    let field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        field.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

document.getElementById("email").addEventListener("input", function () {
    let emailField = this;
    let emailError = document.getElementById("email-error");
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email format

    if (!emailPattern.test(emailField.value)) {
        emailError.style.display = "block";
    } else {
        emailError.style.display = "none";
    }
});
