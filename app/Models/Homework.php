<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    public $table = "homeworks";
    use HasFactory;
    protected $guarded = [];



    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
}
