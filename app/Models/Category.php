<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'slug', 'image'
    ];

     /**
     * Relation One to Many Inverse with Campaign
     * 
     */
    public function campaigns() {
        return $this->hasMany(Campaign::class);
    }

    /**
     * getImageAttribute
     */

    public function getImageAttribute($image)
    {
        return asset('storage/categories/'. $image);
    }
}
