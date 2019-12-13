<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LrdApplication extends Model
{
    public static function getAllJobsByCase($case_number){
        return DB::table('lrd_applications')
            ->where('case_number', '=', $case_number)
            ->get();
    }
}
