<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static Builder where($key, $operator, $value=null)
 * */

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['subcategory','fabric','quality','name','price','description','sale_date_before','image','status'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function quality()
    {
        return $this->belongsTo(Quality::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color','product','color')
            ->withTimestamps()
            ->withPivot(['in_stock']);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_size','product','size')
            ->withTimestamps();
    }

}
