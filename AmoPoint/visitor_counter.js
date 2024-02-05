function getVisitorData() {
    return fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            const ip = data.ip;
            return fetch(`https://ipapi.co/${ip}/json/`);
        })
        .then(response => response.json())
        .then(data => {
            const visitorData = {
                ip: data.ip,
                city: data.city,
                device: navigator.userAgent
            };
            return visitorData;
        })
        .catch(error => console.error('Error fetching visitor data:', error));
}

function sendVisitorData(visitorData) {
    return fetch('backend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(visitorData)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to send visitor data');
            }
        })
        .catch(error => console.error('Error sending visitor data:', error));
}

function countVisit() {
    getVisitorData()
        .then(visitorData => sendVisitorData(visitorData))
        .catch(error => console.error('Error counting visit:', error));
}

countVisit();
