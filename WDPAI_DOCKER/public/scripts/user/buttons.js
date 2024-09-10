const buttonOptions = [
    { name: 'dashboard', path: '/user/dashboard'},
    { name: 'buy', path: '/user/buy'},
    { name: 'available', path: '/user/available'},
    { name: 'expired', path: '/user/expired'},
    { name: 'logout', path: '/auth/logout'}
]

buttonOptions.forEach((option) => {
    document.querySelectorAll('div.go-to-' + option['name']).forEach(button => {
        button.addEventListener('click', () => {
            window.location = option['path'];
        })
    });
})