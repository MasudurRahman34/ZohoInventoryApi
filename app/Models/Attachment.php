<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;
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
        'media_id', 'attachmentable_type', 'attachmentable_id', 'short_link', 'mime_type', 'file_name', 'description', 'meta_data', 'status', 'account_id', 'created_by', 'modified_by', 'created_at', 'deleted_at', 'updated_at'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }
}
