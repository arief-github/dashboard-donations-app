<?php

if (!function_exists('moneyFormat')) {
    /**
     * money format
     *
     * @param mixed $str
     * @return void
     */
    function moneyFormat($str) {
        return 'Rp. '.number_format($str, '0','', '.');
    }
}
