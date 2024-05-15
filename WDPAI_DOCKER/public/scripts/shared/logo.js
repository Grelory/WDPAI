
function renderLogo() {
    const body = document.querySelector('body')

    const div = document.createElement('div')
    div.setAttribute('id', 'logo')

    const paragraph = document.createElement('p')
    const text = document.createTextNode('Quick Bill')
    
    paragraph.appendChild(text)
    div.appendChild(paragraph)
    body.appendChild(div)
}

renderLogo()