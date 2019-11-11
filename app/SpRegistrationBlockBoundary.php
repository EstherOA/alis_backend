<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class SpRegistrationBlockBoundary extends Model
{
    //
    use PostgisTrait;
    use SoftDeletes;

    protected$fillable = [
        'geom', 'shape_leng', 'shape_area', 'objectid', 'src_date', 'blockid',
        'src_info', 'reg_name', 'regioid', 'distriid', 'sectioid', 'loc_name'
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
