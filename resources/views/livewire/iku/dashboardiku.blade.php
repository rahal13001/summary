<div class="container">
    <h4 class="mb-3 text-lg font-large leading-6 text-gray-900">Data IKU</h4>

    <div class="row mb-2">
        <div class="col-md-3 col-sm-3 d-flex">
            <input class="form-control form-control-sm" type="text" placeholder="Cari Nama, Nama IKU....." wire:model.live.debounce.300ms="cari">
        </div>
       
         {{-- Total --}}
         <div class="col-md-3 col-sm-3 d-flex">
              <select wire:model.live="mulai" name="mulai" id="mulai" class="form-control form-control-sm rounded-md shadow-sm">
                <option value="2000" selected>Tahun Mulai</option>
                @foreach ($opsitahuniku as $opsi)
                  <option value="{{ $opsi->tahun }}">{{ $opsi->tahun }}</option>
                @endforeach
              </select>
            {{-- create number input only for writing year --}}
            <select wire:model.live="akhir" name="akhir" id="akhir" class="form-control form-control-sm rounded-md shadow-sm">
              <option value="3000" selected>Tahun Akhir</option>
              @foreach ($opsitahuniku as $opsi)
                <option value="{{ $opsi->tahun }}">{{ $opsi->tahun }}</option>
              @endforeach
            </select>
          </div>

          {{-- Urutan --}}
          <div class="col-md-3 col-sm-3 d-flex">
            <select wire:model.live="orderby" name="orderby" id="orderby" class="form-control form-control-sm rounded-md shadow-sm">
                <option selected value="id">Urutan Default</option>
                <option value="nomor">Nomor</option>
                <option value="nama">Nama</option>
                <option value="tahun">Tahun</option>
            </select>
            <select wire:model.live="asc" name="asc" id="asc" class="form-control form-control-sm rounded-md shadow-sm">
              <option value="ASC">Terkecil</option>
              <option value="DESC">Terbesar</option>
            </select>
        </div>

           {{-- Pagination --}}
            <div class="col-md-2 col-sm-2 d-flex">
                <select wire:model.live="paginate" name="paginate" id="paginate" class="form-control form-control-sm rounded-md shadow-sm">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
      

    </div>
    <div class="row mb-2">
        <div class="col-md-3 col-sm-3">
            <label for="status">Status IKU</label>
            <select name="status" id="status" class="form-control form-control-sm rounded-md shadow-sm" wire:model.live = 'status'>
                <option value="">Semua</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
      

        </div>
          <div class="col-md-3 col-sm-3 d-flex align-items-end">

              @if ($isFormVisible)
                <button type="button" class="btn btn-danger" wire:click="hideForm"> <i class="bi bi-x-lg"></i> Close</button>
              @else
              <button type="button" class="btn btn-primary" wire:click="showForm"> <i class="bi bi-plus-lg"></i>
                Tambah IKU 
              </button>
              @endif
          </div>
        
        {{-- form tambah iku --}}
      @if ($isFormVisible)
          <div class="container">
            <div class="form-group mt-3">
              <label for="nama_iku"><strong>Nama IKU</strong></label>
              <input type="text" name="nama_iku" wire:model.live = "nama_iku" id="nama_iku" class="form-control input-rounded" placeholder="Masukan Nama IKU" value="{{ old('nama_iku') }}" maxlength="250" autofocus>                  
              @error('nama_iku')
              <div class="text-danger mt-2 d-block">{{ $message }}</div> 
              @enderror              
            </div>

            <div class="form-group mt-3 row g-3">
              <div class="col-md-4">
                <label for="nomor_iku"><strong>Nomor IKU</strong></label>
                <input type="number" name="nomor_iku" wire:model.live = "nomor_iku" id="nomor_iku" class="form-control input-rounded" placeholder="Masukan Nomor IKU" value="{{ old('nomor_iku') }}" maxlength="250">                  
                @error('nomor_iku')
                <div class="text-danger mt-2 d-block">{{ $message }}</div> 
                @enderror  
              </div>
              <div class="col-md-4">
                <label for="tahun_iku"><strong>Tahun IKU</strong></label>
                <input type="number" name="tahun_iku" wire:model.live = "tahun_iku" id="tahun_iku" class="form-control input-rounded" placeholder="Masukan Tahun IKU" value="{{ old('tahun_iku') }}" maxlength="250">                  
                @error('tahun_iku')
                <div class="text-danger mt-2 d-block">{{ $message }}</div> 
                @enderror  
              </div>
              <div class="col-md-4">
                <label for="status_iku"><strong>Status IKU</strong></label>
                <select class="form-select" name = "status_iku" wire:model.live="status_iku" aria-label="Default select example">
                  <option disabled selected value>Pilih Status</option>
                  <option value="aktif">Aktif</option>
                  <option value="tidak aktif">Tidak Aktif</option>
                </select>                  
                @error('status_iku')
                <div class="text-danger mt-2 d-block">{{ $message }}</div> 
                @enderror  
              </div>
                                            
            </div>
            @if (!$editForm)
            <div class="mt-3 text-center">
              <button type="button" class="btn btn-primary" wire:click="saveData">Save</button>
            </div>
            @else
            <div class="mt-3 text-center">
              <button type="button" class="btn btn-primary" wire:click="perbarui({{ $id_iku }})">Update</button>
            </div>
            @endif
            
          </div>
      @endif
       
        {{-- ending form tambah iku --}}

        <div class="mt-3">
          @if ($selectPage)
           
          @if ($selectAll)
          Anda Telah Memilih <strong> Seluruh Data ({{ $datas->total() }} Data)</strong>
          <a role="button" class="badge bg-success" wire:click="selectPart" style="text-decoration: none">Pilih Yang Ditampilkan Saja</a>
          @else
          Anda Telah Memilih <strong>{{ count($checked) }} Data</strong>, Apakah Anda Ingin Memilih Seluruh Data <strong>({{ $datas->total() }} Data)</strong> ? 
          <a  role="button" class="badge bg-primary" wire:click="selectAllData" style="text-decoration: none">Pilih Semua</a>
          @endif
    
            
        @endif
        </div>

        <div class="col-md-3 col-sm-3 d-flex">
            <div class="d-grid btn-group d-flex align-items-center" role="group">
              @if ($checked)
              <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Aksi ({{count($checked)}})
              </button>
              <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" onclick="confirm('Yakin Ingin Menghapus {{ count($checked) }} Data ?')||event.stopImmediatePropagation()" wire:click="deleteDatas()">Delete ({{ count($checked) }})</a></li>            
                  {{-- <li><a class="dropdown-item" href="#" onclick="confirm('Yakin Ingin Mengeksport {{ count($checked) }} Data ?')||event.stopImmediatePropagation()" wire:click="eksporexcel">Ekspor Excel ({{ count($checked) }})</a></li>             --}}
              </ul>
              @endif
            </div>
          </div>


    </div>

    @if (session()->has('message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert"">
          {{ session('message') }}
          <button type="button" class="close float-right" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
   @endif
    <div class="table-responsive-lg">
        <table class="table table-hover">
            <thead>
                <tr>
                  <th><input type="checkbox" wire:model.live="selectPage"></th>
                  <th class="text-center">No</th>
                  <th class="text-center">No IKU</th>
                  <th>Nama</th>
                  <th>Tahun</th>
                  <th>Status</th>
                  <th class="text-center">Aksi</th>  
                </tr>
              </thead>
              <tbody>
                @foreach ($datas as $data)
                
                  <tr class="@if ($this->isChecked($data->id)) table-primary @endif" wire:key='{{ $data->id }}'>
                    <td><input type="checkbox" value="{{ $data->id }}" wire:model.live="checked"></td>
                    <td class="text-center">{{ $loop->iteration}}</td>       
                    <td class="text-center">{{ $data->nomor }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->tahun }}</td>
                    <td>{{ $data->status }}</td>
                    <td class="text-center">
                      <a class="btn btn-outline-primary" href="{{ route('ikudashboard', $data->slug) }}"><i class="bi bi-eye-fill"></i></i></a>
                      
                      @if (!$checked)                      
                        <a class="btn btn-outline-warning" wire:click='edit({{ $data->id }})'>
                          <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a class="btn btn-outline-danger"
                        onclick="confirm('Apakah Yakin Ingin Menghapus IKU Nomor {{ $data->nomor }} Bernama {{ $data->nama }} Tahun {{ $data->tahun}}  ?')||event.stopImmediatePropagation()"
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
  

{{-- @push('select2')
 
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endpush --}}
