
document.querySelectorAll('button.go-to-registration').forEach(button => {
    button.addEventListener('click', () => {
        window.location = '/auth/registration'
    })
});

document.querySelectorAll('button.go-to-login').forEach(button => {
    button.addEventListener('click', () => {
        window.location = '/auth/login'
    })
});