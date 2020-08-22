<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Company extends Model
{
    use Billable;

    protected $table = 'companies';

    /**
     * Set all fields as mass assignable
     */
    protected $guarded = [];

    /**
     * Get the users of this company
     */
    // public function users() {
        // return $this->hasMany('App\User');
    // }

    public function inCharge() {
        return $this->belongsTo('App\User', 'in_charge');
    }
}
