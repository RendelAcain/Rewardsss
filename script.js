document.getElementById('hobbies').addEventListener('change', function() {
    var hobbies = this.value;

    fetch('fetch_events.php', {
        method: 'POST',
        body: JSON.stringify({ hobbies: hobbies }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        let eventsList = document.getElementById('events-list');
        eventsList.innerHTML = '';

        data.events.forEach(event => {
            let listItem = document.createElement('li');
            listItem.textContent = event.name;
            eventsList.appendChild(listItem);
        });
    })
    .catch(error => console.log('Error fetching events:', error));
});