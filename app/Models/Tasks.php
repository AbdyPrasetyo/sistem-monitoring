<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tasks extends Model
{
    //
    protected $table = 'tasks';
    protected $fillable = [
        'project_id',
        'title_task',
        'status'
    ];

    /**
     * Get the user that owns the Tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projects(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }
}
