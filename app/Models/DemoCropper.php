<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class DemoCropper extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'demo_cropper';

    protected $casts = [
        'images' => 'array',
    ];

}
