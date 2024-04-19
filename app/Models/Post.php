<?php

namespace App\Models;

use App\Events\PostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    protected $dispatchedEvents = [
        'created' => PostCreated::class
    ];

     /* ===========================================
    =========== Relación con otros Modelos =======
    =========================================== */

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
