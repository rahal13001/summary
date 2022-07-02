<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Exports\Usersaja;
use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\Follower;
use App\Models\Indicator;
use App\Models\Report;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;



class MyreportsController extends Controller
{
 
    public function myreport(Request $request){
        if (request()->ajax()) {

            //Jika request from_date ada value(datanya) maka
            if (!empty($request->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($request->from_date === $request->to_date) {
                    //kita filter tanggalnya sesuai dengan request from_date
                    $query = Report::query()->whereDate('when', '=', $request->from_date)->where('user_id', Auth::user()->id)->with(['user']);
                } else {
                    //kita filter dari tanggal awal ke akhir
                    $query = Report::query()->whereBetween('when', array($request->from_date, $request->to_date))->where('user_id', Auth::user()->id)->with(['user']);
                }
            } else {
                $query = Report::query()->where('user_id', Auth::user()->id)->with(['user']);
            }
            

            return DataTables::of($query)
            ->addColumn('aksi', function ($report) {
                    return '
            <a href = "' . route('myreport_show', $report->slug) . '"
            class = "btn btn-info text-center">
                Detail </a>
            
            ';
                })->rawColumns(['aksi', 'indicator'])
                ->make(true);
        }
        return view('user.report.index');

    }

    public function pengikut(Request $request){
         $pengikut = Follower::where('user_id', Auth::user()->id)->get('report_id');
                        foreach ($pengikut as $peng) {
                        $report_id =  $peng->report_id;
                        }
        if (count($pengikut)==0) {
            return redirect()->back()->with('ikut', 'Anda Belum Mengikuti Siapapun');
        }
                
        if (request()->ajax()) {
            $id = Auth::user()->id;
            //Jika request from_date ada value(datanya) maka
            if (!empty($request->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($request->from_date === $request->to_date) {
                    //kita filter tanggalnya sesuai dengan request from_date
                    $query = Report::query()->whereDate('when', '=', $request->from_date)->with(['user', 'follower'])->whereHas('follower', function($target)use($id){
                        $target->where('user_id', $id);} );
                } else {
                    //kita filter dari tanggal awal ke akhir
                    $query = Report::query()->whereBetween('when', array($request->from_date, $request->to_date))->with(['user', 'follower'])->whereHas('follower', function($target)use($id){
                        $target->where('user_id', $id);} );
                }
            } else {
                $query = Report::query()->with(['user', 'follower'])->whereHas('follower', function($target)use($id){
                        $target->where('user_id', $id);} );
            }
            

            return DataTables::of($query)
            ->addColumn('aksi', function ($report) {
                    return '
            <a href = "' . route('myreport_show', $report->slug) . '"
            class = "btn btn-info text-center">
                Detail </a>
            
            ';
                })->rawColumns(['aksi', 'indicator'])
                ->make(true);
        }

        
        return view('user.report.follower');
    }

    public function create(){

        $report = Report::with('user')->get();
        $user = User::orderBy('name')->get(); 
        $indicator = Indicator::where('status', 'aktif')->get();   

        return view('user.report.create', compact(['report', 'user', 'indicator']));
    }

    public function store(Request $request){

           $request->validate([
             'user_id' => 'required',
             'what' => 'required|max:250',
             'slug' => 'unique:reports,slug',
             'when' => 'required|date',
             'where' => 'required',
             'who' => 'required|max:3500',
             'why' => 'required|max:250',
             'how' => 'required|max:12000',
             'tanggal_selesai' => 'required|date|after_or_equal:when',
             'total_jam' => 'required|numeric',
             'no_st' => 'max:150',
             'dokumentasi1' => 'required|image|max:1024',
             'dokumentasi2' => 'nullable|image|max:1024',
             'dokumentasi3' => 'nullable|image|max:1024',
             'lainnya' => 'nullable|file|max:10240',
             'st' => 'nullable|file|max:3072',
             'gender_wanita' => 'required',
             'total_peserta' => 'required|numeric',
             'penyelenggara' => 'required|max:250'
        ]);
      
        $data = $request->all();
         $date = Carbon::createFromFormat('Y-m-d', $data['when']);
        $tahun = $date->format('Y');
        $bulan = $date->format('M');

      $report = New Report();
       $report->user_id = $data['user_id'];
       $report->what = $data['what'];
       $report->slug = $request->slug;
       $report->where = $data['where'];
       $report->when = $data['when'];
        $report->bulan = $bulan;
        $report->tahun = $tahun;
       $report->who = $data['who'];
       $report->why = $data['why'];
       $report->how = $data['how'];
       $report->tanggal_selesai = $data['tanggal_selesai'];
       $report->total_jam = $data['total_jam'];
       $report->no_st = $data['no_st'];
       $report->gender_wanita = $data['gender_wanita'];
       $report->total_peserta = $data['total_peserta'];
       $report->penyelenggara = $data['penyelenggara'];
        $report->save();
        

            if ($request->indicator == true) {
                        foreach ($request->indicator as $item) {
                            $reports = Report::find($report->id);
                            $reports->indicators()->attach($item);

                      }
                    }

           if ($request->pengikut == true) {
            foreach ($request->pengikut as $item2) {
                $data3 = array(
                    'report_id' => $report->id,
                    'user_id' => $item2
                );
             Follower::create($data3);
                }
        }

 
        if ($request->hasFile('dokumentasi1')) {
            $dokumentasi1_1 = $request->file('dokumentasi1');
            $dokumentasi1_2 = date('Y-m-d') ."_". $request->slug ."_" . $dokumentasi1_1->getClientOriginalName();
            $dokumentasi1_1->storeAs('dokumentasi', $dokumentasi1_2, 'public');
            
        } else {
            $dokumentasi1_2 = null;
        }

          if ($request->hasFile('dokumentasi2')) {
            $dokumentasi2_1 = $request->file('dokumentasi2');
            $dokumentasi2_2 = date('Y-m-d') ."_". $request->slug."_" . $dokumentasi2_1->getClientOriginalName();
            $dokumentasi2_1->storeAs('dokumentasi', $dokumentasi2_2, 'public');
            
        } else {
            $dokumentasi2_2 = null;
        }

        if ($request->hasFile('dokumentasi3')) {
            $dokumentasi3_1 = $request->file('dokumentasi3');
            $dokumentasi3_2 = date('Y-m-d') . "_". $request->slug."_" . $dokumentasi3_1->getClientOriginalName();
            $dokumentasi3_1->storeAs('dokumentasi', $dokumentasi3_2, 'public');
            
        } else {
            $dokumentasi3_2 = null;
        }

         if ($request->hasFile('lainnya')) {
            $lainnya = $request->file('lainnya');
            $lainnya2 = date('Y-m-d') ."_". $request->slug. "_" . $lainnya->getClientOriginalName();
            $lainnya->storeAs('lainnya', $lainnya2, 'public');
            
        } else {
            $lainnya2 = null;
        }

        if ($request->hasFile('st')) {
            $st = $request->file('st');
            $st2 = date('Y-m-d') ."_". $request->slug. "_" . $st->getClientOriginalName();
            $st->storeAs('st', $st2, 'public');
            
        } else {
            $st2 = null;
        }

        $documentation = New Documentation();
        $documentation->report_id = $report->id;
        $documentation->dokumentasi1 = $dokumentasi1_2;
        $documentation->dokumentasi2 = $dokumentasi2_2;
        $documentation->dokumentasi3 = $dokumentasi3_2;
        $documentation->lainnya = $lainnya2;
        $documentation->st = $st2;
        $documentation->save();


        return redirect()->route('myreport')->with('status', '5W1H Berhasil Ditambahkan');
    }

     public function show(Report $report, User $user){       
          
                         
        $follower = Follower::with(['userfoll'])->where('report_id', $report->id)->get();
        return view('user.report.show', compact('follower', 'report'));
    }

    public function edit(Report $report){
          

 
        $reports = Report::get();
         $user = User::orderBy('name')->get();
        //  $tags = Tag::where('report_id', $report->id)->get();   
         $users = User::where('id','!=' ,$report->user_id)->get();
         $indicator = Indicator::where('status', 'Aktif')->get();

        return view('user.report.edit', compact('report', 'user', 'reports', 'users', 'indicator'));

    }

    public function update(Report $report, Request $request){
       
      
       $request->validate([
             'user_id' => 'required',
             'what' => 'required|max:250',
             'when' => 'required|date',
             'who' => 'required|max:3500',
             'why' => 'required|max:250',
             'where' => 'required',
             'how' => 'required|max:12000',
             'tanggal_selesai' => 'required|date|after_or_equal:when',
             'total_jam' => 'required|numeric',
             'no_st' => 'max:150',
             'dokumentasi1' => 'nullable|image|max:1024',
             'dokumentasi2' => 'nullable|image|max:1024',
             'dokumentasi3' => 'nullable|image|max:1024',
             'lainnya' => 'nullable|file|max:10240',
             'st' => 'nullable|file|max:3072',
             'gender_wanita' => 'required',
             'total_peserta' => 'required|numeric',
             'penyelenggara' => 'required|max:250'
        ]);

        $reports = Report::where('id', $report->id);
        $date = Carbon::createFromFormat('Y-m-d', $request->when);
        $tahun = $date->format('Y');
        $bulan = $date->format('M');


        $reports->update([
           'user_id' => $request->user_id,
            'what' => $request->what,
            'when' => $request->when,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'who' => $request->who,
            'how' => $request->how,
            'where' => $request->where,
            'total_jam' => $request->total_jam,
            'tanggal_selesai' => $request->tanggal_selesai,
            'slug' => $request->slug,
            'no_st' => $request->no_st,
            'gender_wanita' => $report->gender_wanita,
            'total_peserta' => $request->total_peserta,
            'penyelenggara' => $request->penyelenggara
        ]);

                        if ($request->indicator == true) {
                        $indicators = Indicator::get();
                        foreach ($indicators as $ind) {
                            $id = $report->indicators->find($ind);
                            $report->indicators()->detach($id);

                             foreach ($request->indicator as $item) {
                                    $report->indicators()->attach($item);
                                }
                        
                        }

                    }

                if ($request->pengikut == true) {
                    Follower::where('report_id', $report->id)->delete();

                    foreach ($request->pengikut as $item2) {
                            $data3 = array(
                                'report_id' => $report->id,
                                'user_id' => $item2
                            );
                        Follower::create($data3);
                    }
                }

         if ($request->hasFile('dokumentasi1')) {
            $dokumentasi1_1 = $request->file('dokumentasi1');
            $dokumentasi1_2 = date('Y-m-d') ."_". $request->slug ."_" . $dokumentasi1_1->getClientOriginalName();
            $dokumentasi1_1->storeAs('dokumentasi', $dokumentasi1_2, 'public');


            Storage::disk('public')->delete(['dokumentasi/' . $report->documentation->dokumentasi1]);
        } else {
            $dokumentasi1_2 = $report->documentation->dokumentasi1;
        }

          if ($request->hasFile('dokumentasi2')) {
            $dokumentasi2_1 = $request->file('dokumentasi2');
            $dokumentasi2_2 = date('Y-m-d') ."_". $request->slug."_" . $dokumentasi2_1->getClientOriginalName();
            $dokumentasi2_1->storeAs('dokumentasi', $dokumentasi2_2, 'public');

            Storage::disk('public')->delete(['dokumentasi/' . $report->documentation->dokumentasi2]);
            
        } else {
            $dokumentasi2_2 = $report->documentation->dokumentasi2;
        }

        if ($request->hasFile('dokumentasi3')) {
            $dokumentasi3_1 = $request->file('dokumentasi3');
            $dokumentasi3_2 = date('Y-m-d') . "_". $request->slug."_" . $dokumentasi3_1->getClientOriginalName();
            $dokumentasi3_1->storeAs('dokumentasi', $dokumentasi3_2, 'public');

            Storage::disk('public')->delete(['dokumentasi/' . $report->documentation->dokumentasi3]);
            
        } else {
            $dokumentasi3_2 = $report->documentation->dokumentasi3;
        }

         if ($request->hasFile('lainnya')) {
            $lainnya = $request->file('lainnya');
            $lainnya2 = date('Y-m-d') ."_". $request->slug. "_" . $lainnya->getClientOriginalName();
            $lainnya->storeAs('lainnya', $lainnya2, 'public');

            Storage::disk('public')->delete(['lainnya/' . $report->documentation->lainnya]);
            
        } else {
            $lainnya2 = $report->documentation->lainnya;
        }


        
         if ($request->hasFile('st')) {
            $st = $request->file('st');
            $st2 = date('Y-m-d') ."_". $request->slug. "_" . $st->getClientOriginalName();
            $st->storeAs('st', $st2, 'public');
            
            Storage::disk('public')->delete(['st/' . $report->documentation->st]);
            
        } else {
            $st2 = $report->documentation->st;
            
        }

         $documentation = Documentation::where('report_id', $report->id);
         $documentation->update([
             'dokumentasi1'=>$dokumentasi1_2,
             'dokumentasi2'=>$dokumentasi2_2,
             'dokumentasi3'=>$dokumentasi3_2,
             'lainnya'=>$lainnya2,
             'st'=>$st2
         ]);

         return redirect()->route('myreport')->with('status', 'Data 5W1H Berhasil Diedit');
    }

    public function delete(Report $report){

        Storage::disk('public')->delete(['dokumentasi/' . $report->documentation->dokumentasi1]);
        Storage::disk('public')->delete(['dokumentasi/' . $report->documentation->dokumentasi2]);
        Storage::disk('public')->delete(['dokumentasi/' . $report->documentation->dokumentasi3]);
        Storage::disk('public')->delete(['st/' . $report->documentation->st]);
        Storage::disk('public')->delete(['lainnya/' . $report->documentation->lainnya]);
        
        Report::where('id', $report->id)->delete();
        
        return redirect()->route('myreport')->with('status', 'Data 5W1H Berhasil Dihapus');

    }

    public function exportexcel(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;

      
        
            return Excel::download(new UsersExport($from_date, $to_date), '5w1hku.xlsx');
      
    }

}
