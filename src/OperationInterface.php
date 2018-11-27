<?php
interface OperationInterface
{
    public function asFloat(array $currencyRates) : float;
    public function describe() : string;
    public function collapse() : array;
}