
const homePath = '/user/'

const icons = [

    { 'letter': 'H', 'fullName': 'Dashboard', 'handler': () => goto('dashboard')},
    { 'letter': 'F', 'fullName': 'Favourites', 'handler': () => goto('favourites')},
    { 'letter': 'B', 'fullName': 'Buy', 'handler': () => goto('buy')},
    { 'letter': 'A', 'fullName': 'Available', 'handler': () => goto('available')},
    { 'letter': 'E', 'fullName': 'Expired', 'handler': () => goto('expired')},
    { 'letter': 'Q', 'fullName': 'Logout', 'handler': () => goto('logout')}
]

function goto(destination) {
    window.location = homePath + destination
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