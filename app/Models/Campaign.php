<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    /**
     * Fillable
     * 
     * @var array
     * 
     */

     protected $fillable = [
        'title', 'slug', 'category_id', 'target_donation', 'max_date',
        'description', 'image', 'user_id',
     ];

     /**
      * Relation with User
      */
      public function user()
      {
        return $this->belongsTo(User::class);
      }

     /**
      * 
      * Relation with Category
      */

      public function category()
      {
        return $this->belongsTo(Category::class);
      }

      /**
       * getImageAttribute
       * 
       * @param mixed $image
       * @return void
       */

       public function getImageAttribute($image)
       {
            return asset('storage/campaigns/'. $image);   
       }

       /**
        * sumDonation
        */
       public function sumDonation()
       {
          return $this->hasMany(Donation::class)->selectRaw('donations.campaign_id, SUM(donations.amount) as total')
          ->where('donation.status', 'success')->groupBy('donations.campaign_id');
       }

} 
