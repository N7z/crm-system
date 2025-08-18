<?php

if (!function_exists('formatPrice')) {
    function formatPrice($value) {
        $value = str_replace(['R$', '.', ' '], '', $value);
        return str_replace(',', '.', $value);
    }
}
