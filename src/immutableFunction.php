<?php
function RUB(float $amount) : ImmutableCurrency
{
    return new ImmutableCurrency($amount, 'RUB');
}

function USD(float $amount) : ImmutableCurrency
{
    return new ImmutableCurrency($amount, 'USD');
}