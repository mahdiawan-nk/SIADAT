<?php

namespace App\Helpers;

use Carbon\Carbon;

function DateTimes($date, $format = 'l, d F Y H:i:s')
{

    return Carbon::parse($date)->format($format);
}
