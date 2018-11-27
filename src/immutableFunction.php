<?php
function RUB(float $number) : ImmutableCurrencyInterface
{
    return new ImmutableCurrency('RUB', $number);
}

function USD(float $number) : ImmutableCurrencyInterface
{
    return new ImmutableCurrency('USD', $number);
}