<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all descendants recursively.
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors recursively.
     */
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Get products in this category.
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    /**
     * Check if this category is a root category.
     */
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if this category has children.
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get the full path of the category (e.g., "Electronics > Phones > Smartphones").
     */
    public function getFullPathAttribute()
    {
        $path = collect([$this->name]);
        $ancestors = $this->ancestors();

        foreach ($ancestors->reverse() as $ancestor) {
            $path->prepend($ancestor->name);
        }

        return $path->implode(' > ');
    }
}
