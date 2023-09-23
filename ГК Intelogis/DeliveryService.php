<?php
require_once('./TransportService.php');

class FastDeliveryService extends TransportService
{
    public function calculate(): array
    {
        $price = 10 * $this->weight; // Example price calculation
        $deliveryDate = date('Y-m-d', strtotime('+2 days')); // Example delivery date calculation

        return [
            'price' => $price,
            'date' => $deliveryDate,
            'error' => ''
        ];
    }
}

class SlowDeliveryService extends TransportService
{
    private $basePrice = 150.00;

    public function calculate(): array
    {
        $price = $this->basePrice * $this->weight; // Example price calculation
        $deliveryDate = date('Y-m-d', strtotime('+5 days')); // Example delivery date calculation

        return [
            'price' => $price,
            'date' => $deliveryDate,
            'error' => ''
        ];
    }
}
?>