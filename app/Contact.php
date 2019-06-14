<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Get the group associated with the contact.
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
