<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class SpDistrict extends Model
{
    //
    use PostgisTrait;
    use SoftDeletes;

    protected$fillable = [
        'geom', 'shape_leng', 'shape_area', 'objectid', 'dist_numb'
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
