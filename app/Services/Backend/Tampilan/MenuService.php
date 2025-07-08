<?php
// app/Services/Backend/Menu/MenuService.php
namespace App\Services\Backend\Tampilan;

use App\Models\Menu;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class MenuService
{
    public function getPagesForMenu()
    {
        return Post::where('post_type', 'page')
            ->where('status', 'Publish')
            ->get();
    }

    public function getAllMenus()
    {
        return Menu::orderBy('order')->get();
    }

    public function getMenusForDatatables()
    {
        return Menu::select(['id', 'title', 'url', 'order', 'parent_id', 'is_active']);
    }

    public function storeMenu(array $data)
    {
        $tautan = '/' . ltrim($data['menus_tautan'], '/');

        return Menu::create([
            'title' => $data['menus_nama'],
            'url' => $tautan,
            'order' => 0,
            'menu_target' => $data['menus_target'],
        ]);
    }

    public function updateMenu(Menu $menu, array $data)
    {
        $tautan = '/' . ltrim($data['menus_tautan'], '/');

        $menu->title = $data['menus_nama'];
        $menu->url = $tautan;
        $menu->menu_target = $data['menus_target'];
        $menu->is_active = $data['menus_aktif'] ?? false;
        $menu->save();

        return $menu;
    }

    public function deleteMenu(Menu $menu)
    {
        $menu->delete();
    }

    public function deleteMultipleMenus(array $ids)
    {
        Menu::whereIn('id', $ids)->delete();
    }

    public function storeFromCheckbox(array $postIds, string $target)
    {
        DB::transaction(function () use ($postIds, $target) {
            foreach ($postIds as $postId) {
                $post = Post::find($postId);

                if ($post) {
                    Menu::create([
                        'title' => $post->title,
                        'url' => '/profil/' . $post->slug,
                        'order' => 0,
                        'menu_target' => $target,
                    ]);
                }
            }
        });
    }

    public function updateOrder(array $orderData)
    {
        DB::transaction(function () use ($orderData) {
            foreach ($orderData as $item) {
                Menu::where('id', $item['id'])
                    ->update([
                        'order' => $item['order'],
                        'parent_id' => $item['parent_id'] ?? null
                    ]);
            }
        });
    }
}
