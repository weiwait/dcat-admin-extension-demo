<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Weiwait\DcatOrderable\SortableTrait;

class OrderableSecond extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasDateTimeFormatter;

    protected array $sortable = [
        'column' => 'order',
        'direction' => 'desc',
        'restriction' => 'orderable_first_id',
    ];
}
