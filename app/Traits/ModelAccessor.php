<?php
namespace App\Traits;

use Carbon\Carbon;

trait ModelAccessor{

    public function getValidFromAttribute(){
       return Carbon::parse($this->attributes['valid_from'])->format('d-M-Y');
    }

    public function getValidToAttribute(){
       return  Carbon::parse($this->attributes['valid_to'])->format('d-M-Y');
    }


}
