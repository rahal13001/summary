<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use Yajra\DataTables\Facades\DataTables;

class ProfilesController extends Controller
{
    public function profile(Request $request){
          
        $id = Auth::user()->id;

        //Data keseluruhan

          $total = Report::with(['user', 'follower'])->whereHas(
                    'follower', function($target)use($id){
                        $target->where('user_id', $id);}
                )->orWhere('user_id', Auth::user()->id);
                   
            $group_total = $total->select( DB::raw('COUNT(id) as data'),
                DB::raw('SUM(total_jam) as jam'))->groupby('bulan')->groupby('tahun')->get();

        //Sebagai penyusun
         $penyusun = Report::with(['user', 'follower'])->where('user_id', Auth::user()->id);
                   
         $group_penyusun = $penyusun->select( DB::raw('COUNT(id) as data'),
                DB::raw('SUM(total_jam) as jam'))->groupby('bulan')->groupby('tahun')->get();          
     
        //Sebagai pengikut
        $pengikut = Report::with(['user', 'follower'])->whereHas(
                    'follower', function($target)use($id){
                        $target->where('user_id', $id);}
                    );
         $group_pengikut = $pengikut->select( DB::raw('COUNT(id) as data'),
                DB::raw('SUM(total_jam) as jam'))->groupby('bulan')->groupby('tahun')->get();
        dd($group_total);
        
        


          if (request()->ajax()) {
               $id = Auth::user()->id;

            //Jika request from_date ada value(datanya) maka
            if (!empty($request->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($request->from_date === $request->to_date) {
                    //kita filter tanggalnya sesuai dengan request from_date
                    $query = Report::query()->whereDate('when', '=', $request->from_date)->with(['user', 'follower'])->whereHas(
                        'follower', function($target)use($id){
                        $target->where('user_id', $id);}
                    )->orWhere('user_id', Auth::user()->id)->orderBy('when', 'DESC');
                } else {
                    //kita filter dari tanggal awal ke akhir
                    $query = Report::query()->whereBetween('when', array($request->from_date, $request->to_date))->with(['user', 'follower'])->whereHas(
                        'follower', function($target)use($id){
                        $target->where('user_id', $id);}
                    )->orWhere('user_id', Auth::user()->id)->orderBy('when', 'DESC');
                }
            } else {
                $query = Report::query()->with(['user', 'follower'])->whereHas(
                    'follower', function($target)use($id){
                        $target->where('user_id', $id);}
                )->orWhere('user_id', Auth::user()->id)->orderBy('when', 'DESC');
            }
            
        }
         
              
        return view('user.profil.dashboard');

    }
}
