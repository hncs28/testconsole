<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'cartID';
    protected $table = 'cart';
    use HasFactory;
    protected $fillable = ['proID', 'userID','quantity'];
    public function product()
    {
        return $this->belongsTo(products::class, 'proID', 'proID');
    }
    use HasFactory;
}
