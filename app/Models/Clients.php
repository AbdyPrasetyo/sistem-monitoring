<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clients extends Model
{
    //
    protected $table = 'clients';
    protected $fillable = [
        'client_name',
        'phone_number',
        'email',
        'address'
    ];

    /**
     * Get all of the comments for the Clients
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Projects::class, 'client_id', 'id');
    }

}
