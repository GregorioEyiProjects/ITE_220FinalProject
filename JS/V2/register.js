
function hideAndShow() {

    var passwordInput = document.getElementById("password");
    var passwordToggleIcon =document.getElementById('password-toggle-icon');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggleIcon.classList.remove('fa-eye');
        passwordToggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = "password";
        passwordToggleIcon.classList.remove('fa-eye-slash');
        passwordToggleIcon.classList.add('fa-eye');
    }
}

function hideAndShow2() {
    const passwordInput = document.querySelector('.password-input'); 
    const passwordToggleIcon =document.querySelector('.password-toggle-icon');

    passwordToggleIcon.addEventListener('click', ()=>{
    alert('clicked');
    
        if(passwordInput.type == 'password'){
            passwordInput.type = 'text';
            passwordToggleIcon.classList.remove('fa-eye');
            passwordToggleIcon.classList.add('fa-eye-slash');
        }else{
            passwordInput.type = 'password';
            passwordToggleIcon.classList.remove('fa-eye-slash');
            passwordToggleIcon.classList.add('fa-eye');
        }
    })
}

function showAlert() {
    alert("Hello there! I aam an alert box!");
}