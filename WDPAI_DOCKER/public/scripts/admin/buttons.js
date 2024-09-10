const buttonOptions = [
    { name: 'dashboard', path: '/admin/dashboard'},
    { name: 'tickets', path: '/admin/tickets'},
    { name: 'locations', path: '/admin/locations'},
    { name: 'providers', path: '/admin/providers'},
    { name: 'transport', path: '/admin/transport'},
    { name: 'types', path: '/admin/types'},
    { name: 'logout', path: '/auth/logout'}
]

buttonOptions.forEach((option) => {
    document.querySelectorAll('div.go-to-' + option['name']).forEach(button => {
        button.addEventListener('click', () => {
            window.location = option['path'];
        })
    });
})