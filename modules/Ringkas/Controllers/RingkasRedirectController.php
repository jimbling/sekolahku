<?php

namespace Modules\Ringkas\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ringkas\Models\RingkasLink;
use Illuminate\Support\Facades\DB;

class RingkasRedirectController extends Controller
{
    public function redirect($slug)
    {
        $link = RingkasLink::where('slug', $slug)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->first();

        if (! $link) {
            abort(404, 'Link tidak ditemukan atau sudah tidak aktif.');
        }

        // Simpan statistik (hit)
        $link->increment('hit_count');

        // (opsional) Simpan ke tabel stats
        DB::table('ringkas_link_stats')->insert([
            'link_id' => $link->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->headers->get('referer'),
            'country' => null,
            'clicked_at' => now(), // hanya ini sebagai timestamp
        ]);

        // Redirect
        return redirect()->to($link->original_url);
    }
}
