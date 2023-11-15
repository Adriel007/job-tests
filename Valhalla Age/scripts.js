// Define the WebSocket URL (adjust as needed)
const socket = new WebSocket('ws://localhost:8080');

// Wait until the WebSocket connection is open
socket.addEventListener('open', (event) => {
    console.log('WebSocket connection open.');
});

// Handle messages received from the server
socket.addEventListener('message', (event) => {
    const data = JSON.parse(event.data);
    // Logic to update the interface with received data
    updateUI(data);
});

// Handle WebSocket errors
socket.addEventListener('error', (event) => {
    console.error('WebSocket connection error:', event);
});

// Function to send a move to the server
function makeMove(cellId) {
    const moveData = {
        type: 'move',
        cellId: cellId,
        // Add any other relevant data
    };
    socket.send(JSON.stringify(moveData));
}

// Function to update the interface with received data
function updateUI(data) {
    if (data.type === 'update') {
        // Update the interface with data received from the server
        const gameStatus = data.gameStatus;
        const playerStats = data.playerStats;

        // Example: Update the game status
        document.getElementById('status').innerText = gameStatus;

        // Example: Update player statistics
        document.getElementById('nickname').innerText = playerStats.nickname;
        document.getElementById('wins').innerText = playerStats.wins;
        document.getElementById('losses').innerText = playerStats.losses;

        // Add logic to update the game board, if necessary
    }
}

// Add event handlers for each cell in the game
const cells = document.querySelectorAll('.cell');
cells.forEach((cell, index) => {
    cell.addEventListener('click', () => {
        makeMove(index);
    });
});
