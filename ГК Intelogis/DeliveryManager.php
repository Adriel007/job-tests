<?php
class DeliveryManager
{
    private $services = [];

    /**
     * Add a transport service to the manager.
     *
     * @param TransportService $service The transport service to add.
     */
    public function addService(TransportService $service)
    {
        $this->services[] = $service;
    }

    /**
     * Calculate delivery results for all added services.
     *
     * @return array An array containing delivery results for each service.
     */
    public function calculateAll()
    {
        $results = [];

        foreach ($this->services as $service) {
            $result = $service->calculate();
            $results[] = [
                'price' => $result['price'],
                'date' => $result['date'],
                'error' => $result['error'],
            ];
        }

        return $results;
    }
}
?>