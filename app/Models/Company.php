<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    /**
     * Set all fields as mass assignable
     */
    protected $guarded = [];

    /**
     * Get the users of this company
     */
    public function users() {
        return $this->hasMany('App\User');
    }
}
