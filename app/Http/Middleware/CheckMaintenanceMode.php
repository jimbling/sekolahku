<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Carbon\Carbon;

class CheckMaintenanceMode
{
    public function handle($request, Closure $next)
    {
        // Ambil data setting
        $siteMaintenance = Setting::where('key', 'site_maintenance')->first();
        $siteEndDate = Setting::where('key', 'site_maintenance_end_date')->first();



        // Periksa apakah data setting ditemukan
        if ($siteMaintenance && $siteEndDate) {
            $maintenanceStatus = $siteMaintenance->setting_value;
            $endDate = $siteEndDate->setting_value;



            // Konversi endDate ke Carbon jika tidak kosong
            if (!empty($endDate)) {
                $endDateCarbon = Carbon::createFromFormat('Y-m-d', $endDate);

                // Debug: Dump endDateCarbon untuk memeriksa hasil konversi


                // Periksa apakah maintenance aktif dan endDate masih berlaku
                if ($maintenanceStatus == true && $endDateCarbon && Carbon::now()->lessThanOrEqualTo($endDateCarbon)) {


                    return redirect('/perawatan');
                }
            }
        }

        return $next($request);
    }
}
