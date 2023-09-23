<?php
header('Content-Type: application/json; charset=utf-8');

require_once('./DeliveryService.php');
require_once('./DeliveryManager.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data !== null) {
        $fastDelivery = new FastDeliveryService($data['base_url'], $data['source_kladr'], $data['target_kladr'], $data['weight']);
        $slowDelivery = new SlowDeliveryService($data['base_url'], $data['source_kladr'], $data['target_kladr'], $data['weight']);

        $manager = new DeliveryManager();
        $manager->addService($fastDelivery);
        $manager->addService($slowDelivery);

        $results = $manager->calculateAll();

        echo json_encode($results);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Bad Request']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>