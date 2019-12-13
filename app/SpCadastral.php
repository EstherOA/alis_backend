<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class SpCadastral extends Model
{
    //
    use PostgisTrait;
    use SoftDeletes;

    protected $fillable = [
        'ccno', 'ref_no', 'reg_no', 'cert_no', 'a_name', 'grantor', 'locality', 'job_number',
        'type_instr', 'date_instr', 'considerat', 'purpose', 'date_com', 'term', 'mul_claim',
        'remarks', 't_code', 'label_code', 'plotted_by', 'checked_by', 'plott_date', 'geom', 'source'
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
