<?php
namespace App\Services;

use App\Models\Org;
use Illuminate\Http\Request;

class OrgService{

    public static function getOrg(Request $request,array $field=[]){

       return Org::orderBy('id','DESC')
        ->where('is_active',1)
        ->select('name','id')
        ->isActive()
        ->get();
    }

    public static function getUser(int $orgId){
        return Org::with(['users'])
        ->where('id',$orgId)
        ->isActive()
        ->first();
    }




}
