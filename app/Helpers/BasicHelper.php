<?php

namespace App\Helpers;

class BasicHelper
{
    public static function dateForFileName(bool $withTimestamp = false, bool $withUnixId = false)
    {
        return join('_', array_merge(
            [
                now()->format('d_m_y_H:i:s')
            ],
            ($withTimestamp ? [time()] : []),
            ($withUnixId ? [uniqid()] : [])
        ));
        // return now()->format('d_m_y_H:i:s') . ($withTimestamp ? ('_' . time()) : '');
    }
}
