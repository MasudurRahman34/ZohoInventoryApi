<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\HasUuids;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    public static $MEDIA_UPLOAD_PATH = 'public/uploads/media/';
    public static $MEDIA_REFERENCE_TABLE = [
        "invoice" => 'App\Models\Invoice',
        "purchase" => 'App\Models\Purchase',
    ];
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'uuid', 'name', 'slug', 'short_link', 'mime_type', 'description', 'meta_description', 'thumbanail_link', 'status', 'account_id', 'created_by', 'modified_by', 'created_at', 'deleted_at', 'updated_at'
    ];

    public function invoice()
    {
        return $this->morphedByMany(Invoice::class, 'taggable', Attachment::class);
    }
}
