<?php
interface ImmutableCurrencyInterface extends ImmutableNumberInterface
{
    public function getCurrency() : string;
}