<?php

namespace App\Http\Controllers\Admin;

use App\Exports\IndicatorsExport;
use App\Http\Controllers\Controller;
use App\Models\Indicator;
use App\Models\Report;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Maatwebsite\Excel\Facades\Excel;

class IndicatorsController extends Controller
{
    public function create(){
        if (request()->ajax()) {
            $query = Indicator::orderBy('tahun', 'DESC')->get();
            return DataTables::of($query)
                ->addColumn('aksi', function ($item) {
                    return '

                    <div class="btn-group float-left" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <li>
                            <a href = "' . route('iku', $item->slug) . '"" class="btn btn-outline-info btn-sm d-block mb-2">
                            Lihat Post </a>
                        </li>
                        <li>
                            <a href = "' . route('indicator_edit', $item->slug) . '"" class="btn btn-outline-warning btn-sm d-block mb-2">
                            Edit </a>
                        </li>
                        <li>
                            <form action="' . route('indicator_delete', $item->slug) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="btn btn-outline-danger d-block btn-sm col-sm-12">
                                    Hapus
                                </button>
                            </form>
                        </li>
                        </ul>
                    </div>

                        ';
                })->rawColumns(['aksi'])
                ->make();
        }
        
        return view('admin.iku.create');

    }

    public function iku(Request $request, Indicator $indicator){

                 
       if (request()->ajax()) {
            
           //Jika this from_date ada value(datanya) maka
             if (!empty($request->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($request->from_date === $request->to_date) {
                    //kita filter tanggalnya sesuai dengan re$request from_date
                     $id = $indicator->id;
                    $query = Report::query()->whereDate('when', '=', $request->from_date)->with(['user', 'indicators', 'follower'])->whereHas(
                    'indicators',function($target) use($id){
                        $target->where('id', $id);})->orderBy('when', 'DESC');
                } else {
                    //kita filter dari tanggal awal ke akhir
                     $id = $indicator->id;
                    $query = Report::query()->whereBetween('when', array($request->from_date, $request->to_date))->where('id', $id)->with(['user', 'indicators', 'follower'])->whereHas(
                    'indicators',function($target) use($id){
                        $target->where('id', $id);})->orderBy('when', 'DESC');
                }
            } else {
                 $id = $indicator->id;
                $query = Report::query()->with(['user', 'indicators', 'follower'])->whereHas(
                    'indicators',function($target) use($id){
                        $target->where('id', $id);})->orderBy('when', 'DESC');
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
        return view('admin.iku.category', compact('indicator'));
    }
    
    public function store(Request $request, Indicator $indicator){
           $request->validate([
            'slug' => 'unique:indicators,slug',
            'nama'=>'required',
            'tahun' => 'required|numeric',
            'status' =>'required',
            'nomor' => 'nullable'
        ]);
        
        $indicator = $request->all();
        Indicator::create(
           $indicator
        );
    return redirect()->route('indicator_create')->with('status', 'Data IKU Berhasil Ditambah');
    }



    public function edit(Indicator $indicator){

        return view('admin.iku.edit', [
            'indicator' => $indicator,
            'indicators' => Indicator::get()
        ]);
    }

    public function update(Request $request, Indicator $indicator){
        $request->validate([
            'nama'=>'required',
            'tahun' => 'required|size:4',
            'status' =>'required',
            'nomor' => 'nullable'
        ]);

        $data = $request->all();
        Indicator::where('id', $indicator->id)
        ->update([
            'nama' => $request->nama,
            'slug' => $request->slug,
            'tahun' => $request->tahun,
            'nomor' => $request->nomor,
            'status' => $request->status
        ]
        );

        return redirect()->route('indicator_create')->with('status', 'IKU Berhasil Di Edit');
    }

    public function destroy (Indicator $indicator){
        Indicator::destroy($indicator->id);
         return redirect()->route('indicator_create')->with('status', 'IKU Berhasil Di Hapus');
    }

     public function checkSlug(Request $request){

        $slug = SlugService::createSlug(Report::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);

    }

       public function exportexcel(Request $request, Indicator $indicator){
        $indicator_id = $indicator->id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $report = Report::with(['indicators', 'user', 'follower'])->get();

        return Excel::download(new IndicatorsExport($from_date, $to_date, $indicator_id, $report), '5w1hperiku.xlsx');
    }
}
