<?php
// app/Http/Controllers/Backend/MenuController.php
namespace App\Http\Controllers\Backend;

use App\Models\Menu;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Services\Backend\Tampilan\MenuService;
use App\Http\Requests\Backend\Tampilan\Menu\MenuStoreRequest;
use App\Http\Requests\Backend\Tampilan\Menu\MenuUpdateRequest;
use App\Http\Requests\Backend\Tampilan\Menu\MenuCheckboxStoreRequest;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function aturMenu()
    {
        $posts = $this->menuService->getPagesForMenu();
        $menus = $this->menuService->getAllMenus();

        $data = [
            'judul' => "Pengaturan Menu",
            'posts' => $posts,
        ];

        return view('admin.tampilan.all_menu', $data, compact('menus'));
    }

    public function getMenu(Request $request)
    {
        if ($request->ajax()) {
            $menus = $this->menuService->getMenusForDatatables();

            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(MenuStoreRequest $request)
    {
        $this->menuService->storeMenu($request->all());

        return response()->json([
            'message' => 'Berhasil menambahkan menu baru.',
            'redirect' => route('menus.all')
        ]);
    }

    public function fetchMenuById($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function update(MenuUpdateRequest $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $this->menuService->updateMenu($menu, $request->all());

        return response()->json(['message' => 'Data Menu berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $this->menuService->deleteMenu($menu);

        return response()->json([
            'type' => 'success',
            'message' => 'Menu berhasil dihapus.'
        ]);
    }

    public function deleteSelectedMenus(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                $this->menuService->deleteMultipleMenus($ids);

                return response()->json([
                    'type' => 'success',
                    'message' => 'Menu berhasil dihapus.'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'message' => 'Tidak ada Menu yang dipilih untuk dihapus.'
            ], 422);
        }
    }

    public function storeFromCheckbox(MenuCheckboxStoreRequest $request)
    {
        try {
            $this->menuService->storeFromCheckbox(
                $request->input('posts', []),
                $request->input('menus_target', '_self')
            );

            return redirect()
                ->route('menus.all')
                ->with('toastr', [
                    'type' => 'success',
                    'message' => 'Menu berhasil ditambahkan.'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('menus.all')
                ->with('toastr', [
                    'type' => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan menu: ' . $e->getMessage()
                ]);
        }
    }


    public function updateOrder(Request $request)
    {
        $this->menuService->updateOrder($request->input('order', []));
        return response()->json(['status' => 'success']);
    }
}
