<?php

function money($value, $prefix = true, $prefixType = '€', $decimals = 2)
{
    return ($prefix ? $prefixType : '') . number_format($value, $decimals, ',', '');
}

function getTaxPrice($price, $tax = 21)
{
    if (strlen($tax) == 1) {
        $tax = '0' . $tax;
    }
    $maths = $price / (1 . $tax) * $tax;

    return $maths;
}
