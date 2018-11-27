<?php
interface ImmutableCurrencyInterface
{
    public function mul(int $multiplier) : ImmutableNumberInterface;
    public function add(ImmutableCurrencyInterface $expression) : ImmutableCurrencyInterface;
    public function sub(ImmutableCurrencyInterface $expression) : ImmutableCurrencyInterface;
    public function describe() : string;
    public function collapse() : array;
    public function asFloat(array $currencyRates) : float;
    public function getAmount() : int;
    public function getCurrency() : string;
}