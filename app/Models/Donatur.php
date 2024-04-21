<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    use HasFactory;

    /**
     * fillable
     * 
     * @var array
     */

     protected $fillable = [
        'name', 'email', 'password', 'avatar'
     ];

     /**
      * hidden
      * @var array
      */

      protected $hidden = [
        'password', 'remember_token',
      ];

      /**
       * donations relation
       */

       public function donations()
       {
          return $this->hasMany(Donation::class);
       }
}
