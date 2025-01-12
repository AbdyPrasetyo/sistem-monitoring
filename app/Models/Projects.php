<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Projects extends Model
{
    //
    protected $table = 'projects';
    protected $fillable = [
        'project_name',
        'leader_id',
        'client_id',
        'start_date',
        'end_date'
    ];


    /**
     * Get all of the comments for the Projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Tasks::class, 'project_id', 'id');
    }

    /**
     * Get the user that owns the Projects
     *
     * @return BelongsTo
     */
    public function clients(): BelongsTo
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }

    /**
     * Get the leader that owns the Projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }
}
