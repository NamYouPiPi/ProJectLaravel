<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audit_log';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'table_name',
        'record_id',
        'action',
        'old_values',
        'new_values',
        'user_type',
        'timestamp',
        'ip_address',
        'user_agent',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'timestamp' => 'datetime',
    ];
    
    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Format the action for display.
     *
     * @return string
     */
    public function getFormattedActionAttribute()
    {
        return ucfirst(strtolower($this->action));
    }
}
