<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Get the contacts in a group.
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }
}
