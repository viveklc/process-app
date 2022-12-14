<?php

use Carbon\Carbon;

if (!function_exists('selectBoxSelectedItems')) {
    function selectBoxSelectedItems($inputDataArray = [])
    {
        return (in_array('all', $inputDataArray) || in_array('999999', $inputDataArray))
                ? ['all', '999999']
                : $inputDataArray;
    }
}

if (!function_exists('formatNumberAsPrice')) {
    function formatNumberAsPrice($number = 0)
    {
        return number_format($number, 2);
    }
}

if (!function_exists('appDateFormat')) {
    function appDateFormat($inputDate, $dateFormat = null)
    {
        if(!is_null($inputDate)){
            $returnDateFormat = "";
        if(filled($dateFormat)) {
            $returnDateFormat = Carbon::parse($inputDate)->format($dateFormat);
        } else {
            $returnDateFormat = Carbon::parse($inputDate)->format(config('app-config.date_format.date', 'd/m/Y'));
        }
        return $returnDateFormat;
        }else{
            return "";
        }
    }
}

if(!function_exists('dbDateFormat')){
    function dbDateFormat($date){
        if(!is_null($date)){
            return Carbon::parse($date)->format('Y-m-d');
        }else{
            return null;
        }

    }
}

if(!function_exists('DateTimeFormat')){
    function DateTimeFormat($datetime){
        return Carbon::parse($datetime)->format('Y-m-d H:i');
    }
}
