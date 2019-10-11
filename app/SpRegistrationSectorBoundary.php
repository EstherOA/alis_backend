<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class SpRegistrationSectorBoundary extends Model
{
    //
    use PostgisTrait;
    use SoftDeletes;

    protected$fillable = [
        'geom', 'shape_leng', 'shape_area', 'objectid', 'src_date',
        'src_info', 'reg_name', 'regioid', 'distriid', 'loc_name', 'sectioid'
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
