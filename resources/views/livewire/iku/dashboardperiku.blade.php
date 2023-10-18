<div class="container">
    <h4 class="mb-3 text-lg font-large leading-6 text-gray-900">Data Summary Per IKU</h4>

    <div class="row mb-2">
        <div class="col-md-3 col-sm-3 d-flex">
            <input class="form-control form-control-sm" type="text" placeholder="Cari What, Where, Penyusun..." wire:model.live.debounce.300ms="cari">
        </div>
       
         {{-- Tanggal --}}
         <div class="col-md-3 col-sm-3 d-flex">
            <input class="form-control form-control-sm" type="date" placeholder="Tanggal Mulai" wire:model.live.debounce.300ms="mulai">
            <input class="form-control form-control-sm" type="date" placeholder="Tanggal Akhir" wire:model.live.debounce.300ms="akhir">
          </div>  

          {{-- Urutan --}}
          <div class="col-md-3 col-sm-3 d-flex">
            <select wire:model.live="orderby" name="orderby" id="orderby" class="form-control form-control-sm rounded-md shadow-sm">
                <option selected value="id">Urutan Default</option>
                <option value="what">What</option>
                <option value="when">When</option>
                <option value="user_id">Penyusun</option>
            </select>
            <select wire:model.live="asc" name="asc" id="asc" class="form-control form-control-sm rounded-md shadow-sm">
              <option value="ASC">Terkecil</option>
              <option value="DESC">Terbesar</option>
            </select>
        </div>

           {{-- Pagination --}}
            <div class="col-md-2 col-sm-2 d-flex">
                <select wire:model.live="paginate" name="paginate" id="paginate" class="form-control form-control-sm rounded-md shadow-sm">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>


    </div>

   <div class="table-responsive-lg">
      <table class="table table-hover">
          <thead>
              <tr>
                <th><input type="checkbox" wire:model.live="selectPage"></th>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal</th>
                <th>What</th>
                <th>Where</th>
                <th>Penyusun</th>
                <th class="text-center">Aksi</th>  
              </tr>
            </thead>
            <tbody>
              @foreach ($datas as $data)
              
              <tr class="@if ($this->isChecked($data->id)) table-primary @endif" wire:key='{{ $data->id }}'>
                <td><input type="checkbox" value="{{ $data->id }}" wire:model.live="checked"></td>
                <td class="text-center">{{ $loop->iteration}}</td>       
                <td class="text-center">{{ Carbon\Carbon::parse($data->when)->format('d-m-Y') }}</td>
                <td>{{ $data->what }}</td>
                <td>{{ $data->where }}</td>
                <td>{{ $data->user->name }}</td>
                <td class="text-center">
                  <a class="btn btn-outline-primary" href="{{ route('report_detail', $data->slug) }}" ><i class="bi bi-eye-fill"></i></i></a>
                  
                  @if (!$checked)                      
                  <a class="btn btn-outline-danger"
                  onclick="confirm('Apakah Yakin Ingin Menghapus Data Survei Judul {{ $data->what }} Tanggal {{ $data->when }} Milik {{ $data->user->name }}  ?')||event.stopImmediatePropagation()"
                  wire:click="deleteSatuData({{$data->id}})" ><i class="bi bi-trash-fill"></i></a>
                  @endif
                </td>
              </tr>
            
            @endforeach

            </tbody>
          </table>
      </div>



        <div class="row mt-4">
            <div class="col-sm-12">
              {{ count($datas) }} dari {{ $datas->total() }}
            </div>
            <div class="col-sm-12">
              {{ $datas->links() }}
            </div>
          </div>


</div>
