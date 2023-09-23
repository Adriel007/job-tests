<?php
abstract class TransportService
{
    protected $base_url;
    protected $sourceKladr;
    protected $targetKladr;
    protected $weight;

    public function __construct(string $base_url, string $sourceKladr, string $targetKladr, float $weight)
    {
        $this->base_url = $base_url;
        $this->sourceKladr = $sourceKladr;
        $this->targetKladr = $targetKladr;
        $this->weight = $weight;
    }

    abstract public function calculate(): array;
}

?>