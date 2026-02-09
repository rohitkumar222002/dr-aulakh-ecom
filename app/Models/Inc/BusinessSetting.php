<?php

namespace App\Models\Inc;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    protected $table = 'business_settings';
    protected $guarded = [];

    public function gstState()
{
    return $this->belongsTo(State::class, 'value', 'id')
                ->where('type', 'gst_state');
}

}
