<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AddKpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckKpiOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Dapatkan ID KPI dari parameter route
        $kpiId = $request->route('add_kpi');
        
        // Cari KPI berdasarkan ID yang diperoleh
        $kpi = AddKpi::find($kpiId);

        // Periksa jika KPI wujud dan pemilik KPI adalah pengguna yang sedang log masuk
        if ($kpi && $kpi->pemilik == Auth::user()->name) {
            // Teruskan permintaan ke lapisan seterusnya
            return $next($request);
        }

        // Jika syarat tidak dipenuhi, arahkan pengguna ke halaman utama dengan mesej ralat
        return redirect('/')->with('error', 'Anda tidak mempunyai kebenaran untuk melihat KPI ini.');
    }
}
