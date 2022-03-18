<?php

namespace Weiwait\DcatIcon\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

class WeiwaitIcon extends \Illuminate\Database\Eloquent\Model
{
    use HasDateTimeFormatter;

    const SVG = 0;

    const TYPE = [
        'svg', 'icon-font'
    ];

    protected $guarded = [];
}
