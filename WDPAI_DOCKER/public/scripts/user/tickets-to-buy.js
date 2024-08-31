const options = []

const providerSelect = document.querySelector('select#provider');
const locationSelect = document.querySelector('select#location');
const transportSelect = document.querySelector('select#transport-type');
const typeSelect = document.querySelector('select#ticket-type');

function distinct(value, index, array) {
    return array.indexOf(value) === index;
}

function addOptions(select, value) {
    const option = document.createElement('option');
    option.value = value;
    option.text = value;
    select.add(option);
}

function clearOptions(...selects) {
    selects.forEach(select => {
        select.querySelectorAll('option').forEach(option => option.remove());
        const option = document.createElement('option');
        option.value = '';
        option.text = 'Select';
        select.add(option);
    });
}

function loadProviders() {
    options
        .map(opt => opt.providerName)
        .filter(distinct)
        .forEach(provider => addOptions(providerSelect, provider))
}

function loadLocations(provider) {
    options
        .filter(opt => opt.providerName === provider)
        .map(opt => opt.locationName)
        .filter(distinct)
        .forEach(location => addOptions(locationSelect, location))
}

function loadTransportTypes(provider, location) {
    options
        .filter(opt => opt.providerName === provider && opt.locationName === location)
        .map(opt => opt.transportTypeName)
        .filter(distinct)
        .forEach(transport => addOptions(transportSelect, transport))
}

function loadTicketTypes(provider, location, transport) {
    options
        .filter(opt => opt.providerName === provider 
            && opt.locationName === location
            && opt.transportTypeName == transport)
        .map(opt => opt.ticketTypeName)
        .filter(distinct)
        .forEach(type => addOptions(typeSelect, type))
}

document.querySelector('select#provider').addEventListener('change', () => {
    const provider = document.querySelector('select#provider').value;
    clearOptions(locationSelect, transportSelect, typeSelect);
    loadLocations(provider);
});

document.querySelector('select#location').addEventListener('change', () => {
    const provider = document.querySelector('select#provider').value;
    const location = document.querySelector('select#location').value;
    clearOptions(transportSelect, typeSelect);
    loadTransportTypes(provider, location);
});

document.querySelector('select#transport-type').addEventListener('change', () => {
    const provider = document.querySelector('select#provider').value;
    const location = document.querySelector('select#location').value;
    const transport = document.querySelector('select#transport-type').value;
    clearOptions(typeSelect);
    loadTicketTypes(provider, location, transport);
});

fetch(
    window.location.origin + '/resources/tickets-to-buy',
    {
        'method': 'GET',
        'credentials': 'include',
        'Accepts': 'application/json'
    }
)
.then(response => response.json())
.then(json => json.forEach(option => options.push(option)))
.then(loadProviders)
.catch(error => console.log(error));
