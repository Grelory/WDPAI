function buyFavourite(ticket) {
    console.log('Buy favourite ticket:')
    console.log(ticket)
}

function deleteFavourite(ticket) {
    console.log('Delete favourite ticket:')
    console.log(ticket)
    ticket.remove()
}

function createButton(text, handler) {
    const button = document.createElement('button')
    button.addEventListener('click', handler)
    button.appendChild(document.createTextNode(text))
    return button
}

document.querySelectorAll("div.tickets.favourites div.ticket").forEach(ticket => {
    ticket.appendChild(createButton('Buy', () => buyFavourite(ticket)))
    ticket.appendChild(createButton('Delete', () => deleteFavourite(ticket)))
})