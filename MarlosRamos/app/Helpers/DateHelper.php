<?php

namespace App\Helpers;

class DateHelper
{
    public static function greeting()
    {
        $hour = now()->format('H');

        if ($hour >= 5 && $hour < 12) {
            return 'Bom dia';
        } elseif ($hour >= 12 && $hour < 18) {
            return 'Boa tarde';
        }

        return 'Boa noite';
    }
}
