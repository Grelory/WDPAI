const icons = [

    { 'letter': 'H', 'fullName': 'Dashboard', 'handler': () => goto('/admin/dashboard')},
    { 'letter': 'T', 'fullName': 'Tickets', 'handler': () => goto('/admin/tickets')},
    { 'letter': 'L', 'fullName': 'Locations', 'handler': () => goto('/admin/locations')},
    { 'letter': 'P', 'fullName': 'Providers', 'handler': () => goto('/admin/providers')},
    { 'letter': 'R', 'fullName': 'Transport', 'handler': () => goto('/admin/transport')},
    { 'letter': 'Y', 'fullName': 'Types', 'handler': () => goto('/admin/types')},
    { 'letter': 'Q', 'fullName': 'Logout', 'handler': () => goto('/auth/logout')}
]

function goto(destination) {
    window.location = destination
}

function navbarElements() {
    
    return icons.map(icon => {
        const element = document.createElement('p')
        element.appendChild(document.createTextNode(icon.letter))
        element.classList.add('icon')
        element.addEventListener('click', icon.handler)
        return element
    })

}

function renderNavigationBar() {
    const body = document.querySelector('body')

    const div = document.createElement('div')
    div.setAttribute('id', 'navbar')

    navbarElements().forEach(element => div.appendChild(element))

    body.appendChild(div)
}

renderNavigationBar()