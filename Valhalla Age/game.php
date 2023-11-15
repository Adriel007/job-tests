<?php
require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class TicTacToe implements MessageComponentInterface
{
    protected $clients;
    protected $playerStats;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->playerStats = []; // Associative array to store player stats
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        // Assign a default nickname to the player
        $this->playerStats[$conn->resourceId] = [
            'nickname' => 'Player ' . $conn->resourceId,
            'wins' => 0,
            'losses' => 0,
        ];

        echo "Connection {$conn->resourceId} has opened.\n";

        // Send an initial message to the client
        $conn->send(json_encode([
            'type' => 'welcome',
            'nickname' => $this->playerStats[$conn->resourceId]['nickname'],
        ]));
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if ($data['type'] === 'move') {
            // Process the move and update game state

            // Example: Send updated game state to all clients
            $this->broadcast(json_encode([
                'type' => 'update',
                'gameStatus' => 'Player ' . $from->resourceId . ' made a move.',
                'playerStats' => $this->playerStats,
            ]));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Remove the connection when the client closes the connection
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has closed.\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    protected function broadcast($msg)
    {
        // Send a message to all clients
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }
}

// Run the WebSocket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new TicTacToe()
        )
    ),
    8080
);

$server->run();
