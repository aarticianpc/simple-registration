function checkemail() {
    const email = document.getElementById('email');
    const emailFeedback = document.getElementById('email-feedback');
    const filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    email.classList.remove('invalid');
    emailFeedback.innerHTML = '';
    if (!filter.test(email.value)) {
        email.classList.add('invalid');
        emailFeedback.innerHTML = 'Please enter valid email';
        email.focus;
        return false;
    } else {
        return true;
    }
}

function checkLoginForm(event) {
    const loginForm = document.getElementById('login-form');

    const password = document.getElementById('password');
    const passwordFeedback = document.getElementById('password-feedback');
    password.classList.remove('invalid');
    passwordFeedback.innerHTML = '';

    if(!checkemail()) {
        event.preventDefault();
        return false;
    } else if(!password.value) {
        password.classList.add('invalid');
        passwordFeedback.innerHTML = 'Please enter password';
        password.focus;
        event.preventDefault();
        return false;
    } else if(password.value.length < 8) {
        password.classList.add('invalid');
        passwordFeedback.innerHTML = 'Please enter min 8 char long password';
        password.focus;
        event.preventDefault();
        return false;
    } else {
        return true;
    }
}

function checkRegisterForm(event) {
    if(!checkLoginForm(event)) {
        event.preventDefault();
        return false;
    }
}
