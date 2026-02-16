<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParasolsImage extends Model
{
    protected $table = 'parasols_images';

    protected $fillable = [
        'region_id',
        'image_path',
        'title_ar',
        'title_en',
        'location_ar',
        'location_en',
        'price',
        'status',
        'sort_order',
    ];

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_ENDING_SOON = 'ending_soon';
    public const STATUS_ENDED = 'ended';

    public function region()
    {
        return $this->belongsTo(ParasolsRegion::class, 'region_id');
    }
}
