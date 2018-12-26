<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class Good extends Model
{
    use Searchable;
    protected $fillable = [
        'title','price','description','content','list_pic','pics',
        'category_id','admin_id','total'
    ];
    protected $casts = [
        'pics' => 'array'//转为数组格式
    ];
    public function specs(){
        return $this->hasMany(Spec::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
