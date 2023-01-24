<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMarketPlace extends Model
{
    use HasFactory;    
    
    protected $table = "m_marketplace";
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
