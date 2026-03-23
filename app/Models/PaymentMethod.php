<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'label',
        'sub_label',
        'icon_class',
        'icon_text',
        'last_four',
        'expiry',
        'is_default',
        'meta',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'meta'       => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
