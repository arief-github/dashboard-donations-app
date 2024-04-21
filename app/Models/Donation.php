<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    /**
     * fillable
     * 
     * @var array
     */

     protected $fillable = [
        'invoice',
        'campaign_id',
        'donatur_id',
        'amount',
        'pray',
        'status',
        'snap_token'
     ];

     /**
      * category relation
      * @return void
      */

      public function category()
      {
         return $this->belongsTo(Category::class);
      }

      /**
       * user relation
       * @return void
       */

       public function user()
       {
         return $this->belongsTo(User::class);
       }

       /**
        * Campaign Relation
        * @return void
        */
        public function campaign()
        {
            return $this->belongsTo(Campaign::class);
        }

        /**
         * Donatur Relations
         */

         public function donatur()
         {
            return $this->belongsTo(Donatur::class);
         }
}
