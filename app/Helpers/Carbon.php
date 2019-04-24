<?php

/**
 * Carbon helper
 *
 * @param $time
 * @param $tz
 *
 * @return Carbon\Carbon
 * @version 2.1
 */
function carbon($time = null, $tz = null)
{
    return new \Carbon\Carbon($time, $tz);
}
