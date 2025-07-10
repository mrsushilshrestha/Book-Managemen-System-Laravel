<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'published_year',
        'description',
        'category_id',      
        'cover_image_path', 
        'user_id', 
    ];

    /**
     * Relationships
     */

    // Book belongs to a Category (optional)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scopes (custom query helpers)
     */

    // Scope: get books published after a certain year
    // public function scopePublishedAfter($query, $year)
    // {
    //     return $query->where('published_year', '>', $year);
    // }

    /**
     * Accessors & Mutators
     */

    // Example accessor: Get title in uppercase
    public function getTitleUppercaseAttribute()
    {
        return strtoupper($this->title);
    }

    // Example mutator: Automatically capitalize title when saving
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords(strtolower($value));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
