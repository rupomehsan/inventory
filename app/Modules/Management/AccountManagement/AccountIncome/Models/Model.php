<?php

namespace App\Modules\Management\AccountManagement\AccountIncome\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
class Model extends EloquentModel
{
    use SoftDeletes;
    protected $table = "account_incomes";
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($data) {
            $random_no = random_int(100, 999) . $data->id . random_int(100, 999);
            $slug = $data->title . " " . $random_no;
            $data->slug = Str::slug($slug); //use Illuminate\Support\Str;
            if (strlen($data->slug) > 50) {
                $data->slug = substr($data->slug, strlen($data->slug) - 50, strlen($data->slug));
            }
            if (auth()->check()) {
                $data->creator = auth()->user()->id;
            }
            $data->save();
        });
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

     public function scopeInactive($q)
    {
        return $q->where('status', 'inactive');
    }
     public function scopeTrased($q)
    {
        return $q->onlyTrashed();
    }

    public function account_category()
    {
        return $this->belongsTo('App\Modules\Management\AccountManagement\AccountCategory\Models\Model', 'account_category_id');
    }
}
