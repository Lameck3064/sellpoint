document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById("loginBtn");
    const registerBtn = document.getElementById("registerBtn");
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const forgotPasswordForm = document.getElementById("forgotPasswordForm");
    const switchToRegister = document.getElementById("switchToRegister");
    const switchToLogin = document.getElementById("switchToLogin");
    const forgotPasswordLink = document.getElementById("forgotPasswordLink");
    const switchToLoginFromForgot = document.getElementById("switchToLoginFromForgot");

    // Toggle between Login and Register forms
    loginBtn.addEventListener("click", () => {
        loginForm.classList.add("active");
        registerForm.classList.remove("active");
        forgotPasswordForm.classList.remove("active");
        loginBtn.classList.add("active");
        registerBtn.classList.remove("active");
    });

    registerBtn.addEventListener("click", () => {
        registerForm.classList.add("active");
        loginForm.classList.remove("active");
        forgotPasswordForm.classList.remove("active");
        registerBtn.classList.add("active");
        loginBtn.classList.remove("active");
    });

    // Show Forgot Password Form
    forgotPasswordLink.addEventListener("click", () => {
        forgotPasswordForm.classList.add("active");
        loginForm.classList.remove("active");
        registerForm.classList.remove("active");
    });

    // Switch back to Login from Forgot Password
    switchToLoginFromForgot.addEventListener("click", () => {
        loginForm.classList.add("active");
        forgotPasswordForm.classList.remove("active");
    });

    // Switch directly from footer links
    switchToRegister.addEventListener("click", () => {
        registerBtn.click();
    });

    switchToLogin.addEventListener("click", () => {
        loginBtn.click();
    });
});
// Validation Function
function validateForm() {
    var name = document.getElementById("product_name").value;
    var description = document.getElementById("product_description").value;
    var price = document.getElementById("product_price").value;
    var image = document.getElementById("product_image").value;

    if (name == "" || description == "" || price == "" || image == "") {
        alert("All fields are required.");
        return false;
    }
    return true;
}
