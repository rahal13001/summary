<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminsExport;
use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\Follower;
use App\Models\Indicator;
use App\Models\Report;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;

use function Psy\debug;

class ReportsController extends Controller
{

    
    public function index(Request $request){
            
         if (request()->ajax()) {

            //Jika request from_date ada value(datanya) maka
            if (!empty($request->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($request->from_date === $request->to_date) {
                    //kita filter tanggalnya sesuai dengan request from_date
                    $query = Report::query()->whereDate('when', '=', $request->from_date)->with(['user'])->orderBy('when', 'DESC');
                } else {
                    //kita filter dari tanggal awal ke akhir
                    $query = Report::query()->whereBetween('when', array($request->from_date, $request->to_date))->with(['user'])->orderBy('when', 'DESC');
                }
            } else {
                $query = Report::query()->with(['user'])->orderBy('when', 'DESC');
            }
            

            return DataTables::of($query)
            ->addColumn('aksi', function ($report) {
                    return '
            <a href = "' . route('report_show', $report->slug) . '"
            class = "btn btn-info text-center">
                Detail </a>
            
            ';
                })->rawColumns(['aksi', 'indicator'])
                ->make(true);
        }
        return view('admin.report.index');
    }
    public function create(){

        $report = Report::with('user')->get();
        $user = User::orderBy('name')->get();
        $indicator = Indicator::where('status', 'aktif')->get();   

        return view('admin.report.create', compact(['report', 'user', 'indicator']));
    }

    public function store(Request $request){

         $request->validate([
             'user_id' => 'required',
             'what' => 'required|max:250',
             'slug' => 'unique:reports,slug',
             'when' => 'required|date',
             'who' => 'required|max:500',
             'why' => 'required|max:250',
             'how' => 'required|max:2000',
             'tanggal_selesai' => 'required|date|after_or_equal:when',
             'total_jam' => 'required|numeric',
             'no_st' => 'required|max:150',
             'dokumentasi1' => 'required|image|max:1024',
             'dokumentasi2' => 'nullable|image|max:1024',
             'dokumentasi3' => 'nullable|image|max:1024',
             'lainnya' => 'nullable|file|max:10240',
             'st' => 'nullable|file|max:3072',
             'gender_wanita'=>'required',
             'total_peserta' => 'required|numeric'
        ]);
      
        $data = $request->all();
            
        //mengambil bulan dan tahun
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


        return redirect()->route('report_index')->with('status', '5W1H Berhasil Ditambahkan');
    }

    public function show(Report $report, User $user){  
         
        $rep = $report->user_id;
        $user = Auth::user()->id;        
        $cek = $report->follower->find($user);

        

        $follower = Follower::with(['userfoll'])->where('report_id', $report->id)->get();
        return view('admin.report.show', compact('follower', 'report'));
    }

    public function edit(Report $report){

        // $rep = $report->user_id;
        // $user = Auth::user()->id;        
        // $cek = $report->follower->find($user);
        
        // if (is_null($cek) && $user !== $rep) {
        //    return abort(403, Auth::user()->name.' Mo Apa Ko ! Mending Ko Balik -_-');
        // }
 
         $reports = Report::get();
         $user = User::orderBy('name')->get();
        //  $tags = Tag::where('report_id', $report->id)->get();   
         $users = User::where('id','!=' ,$report->user_id)->get();
         $indicator = Indicator::where('status', 'Aktif')->get();

        return view('admin.report.edit', compact('report', 'user', 'reports', 'users', 'indicator'));

    }

    public function update(Report $report, Request $request){

        
          $request->validate([
             'user_id' => 'required',
             'slug' =>'nullable',
             'what' => 'required|max:250',
             'when' => 'required|date',
             'who' => 'required|max:500',
             'why' => 'required|max:250',
             'how' => 'required|max:2000',
             'tanggal_selesai' => 'required|date|after_or_equal:when',
             'total_jam' => 'required|numeric',
             'no_st' => 'nullable|max:150',
             'dokumentasi1' => 'nullable|image|max:1024',
             'dokumentasi2' => 'nullable|image|max:1024',
             'dokumentasi3' => 'nullable|image|max:1024',
             'lainnya' => 'nullable|file|max:10240',
             'st' => 'nullable|file|max:3072',
             'gender_wanita' => 'required',
             'total_peserta' => 'total_peserta'
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
            'gender_wanita' => $request->gender_wanita,
            'total_peserta' => $request->total_peserta
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
            $lainnya2 = null;
        }


        
         if ($request->hasFile('st')) {
            $st = $request->file('st');
            $st2 = date('Y-m-d') ."_". $request->slug. "_" . $st->getClientOriginalName();
            $st->storeAs('st', $st2, 'public');

            Storage::disk('public')->delete(['st/' . $report->documentation->lainnya]);
            
        } else {
            $st2 = null;
        }

         $documentation = Documentation::where('report_id', $report->id);
         $documentation->update([
             'dokumentasi1'=>$dokumentasi1_2,
             'dokumentasi2'=>$dokumentasi2_2,
             'dokumentasi3'=>$dokumentasi3_2,
             'lainnya'=>$request->lainnya2,
             'st'=>$request->st2
         ]);

         return redirect()->route('report_index')->with('status', 'Data 5W1H Berhasil Diedit');
    }   

    public function delete(Report $report){

        $rep = $report->user_id;
        $user = Auth::user()->id;        
        $cek = $report->follower->find($user);
        
        if (is_null($cek) && $user !== $rep) {
           return abort(403, Auth::user()->name.' Mo Apa Ko ! Mending Ko Balik -_-');
        }

        Storage::disk('public')->delete(['lainnya/' . $report->documentation->dokumentasi1]);
        Storage::disk('public')->delete(['lainnya/' . $report->documentation->dokumentasi2]);
        Storage::disk('public')->delete(['lainnya/' . $report->documentation->dokumentasi3]);
        Storage::disk('public')->delete(['lainnya/' . $report->documentation->lainnya]);
        
        Report::where('id', $report->id)->delete();
        
        return redirect()->route('report_index')->with('status', 'Data 5W1H Berhasil Dihapus');

    }

    public function checkSlug(Request $request){

        $slug = SlugService::createSlug(Report::class, 'slug', $request->what);
        return response()->json(['slug' => $slug]);

    }

    public function export_pdf(Report $report){
        $follower = Follower::with(['userfoll'])->where('report_id', $report->id)->get();
        $pdf = PDF::loadView('pdf.pdftes', compact('report', 'follower'))->setPaper('a4');
        return $pdf->download($report->when.'_'.$report->slug.'.pdf');
    }

     public function exportexcel(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        return Excel::download(new AdminsExport($from_date, $to_date), '5w1hsemua.xlsx');
    }

    public function viewpdf(Report $report){
        $lainnya = $report->documentation->lainnya;  
        return view('lihat.lihatlainnya', compact('lainnya'));
    }

     public function viewst(Report $report){
        $lainnya = $report->documentation->st;  
        return view('lihat.lihatst', compact('lainnya'));
    }

}
