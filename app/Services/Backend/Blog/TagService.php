<?php
// app/Services/Backend/Tag/TagService.php
namespace App\Services\Backend\Blog;

use App\Models\Tag;
use Illuminate\Support\Str;

class TagService
{
    public function getAllTags()
    {
        return Tag::all();
    }

    public function getTagsForDatatables()
    {
        return Tag::select(['id', 'name', 'slug']);
    }

    public function storeTag(array $data)
    {
        $slug = Str::slug($data['tag_name'], '-');

        return Tag::create([
            'name' => $data['tag_name'],
            'slug' => $slug,
        ]);
    }

    public function updateTag(Tag $tag, array $data)
    {
        $tag->name = $data['name'];
        $tag->slug = Str::slug($data['name'], '-');
        $tag->save();

        return $tag;
    }

    public function deleteTag(Tag $tag)
    {
        $tag->delete();
    }

    public function deleteMultipleTags(array $ids)
    {
        Tag::whereIn('id', $ids)->delete();
    }
}
