<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_type', 'keterangan',
    ];

    /**
     * Get all categories.
     */
    public static function getAllCategories()
    {
        return Category::all();
    }

    /**
     * Get a category by ID.
     *
     * @param int $id
     * @return Category|null
     */
    public static function getCategoryById($id)
    {
        return Category::find($id);
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public static function createCategory($data)
    {
        return Category::create($data);
    }

    /**
     * Update a category.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function updateCategory($id, $data)
    {
        $category = Category::find($id);
        if ($category) {
            return $category->update($data);
        }
        return false;
    }

    /**
     * Delete a category.
     *
     * @param int $id
     * @return bool
     */
    public static function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $category->delete();
        }
        return false;
    }

    public static function getAllFileCategories()
    {
        return Category::where('category_type', 'file')->get();
    }

    /**
     * Relationship with posts.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }
}
