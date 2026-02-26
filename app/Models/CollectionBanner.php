<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionBanner extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $table = "collection_banner";
}
