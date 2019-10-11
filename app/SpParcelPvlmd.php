<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class SpParcelPvlmd extends Model
{
    //
    use PostgisTrait;
    use SoftDeletes;

    protected $fillable = [
        'src_info', 'src_date', 'pvlmdid', 'map_numb', 'la_tenure',
        'remarks', 'geom', 'source'
    ];

    protected $postgisFields = [
        'geom'
    ];

    protected $postgisTypes = [
        'geom' => [
            'geomtype' => 'geometry',
            'srid' => 3857
        ]
    ];
}
