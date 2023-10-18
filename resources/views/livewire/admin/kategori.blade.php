<div>
    
        <div class="container">
            <h2 class="mb-3 text-lg font-large leading-6 text-gray-900">Data Kelompok Kerja</h2>
    
        <div class="row mb-2">
                {{-- Kolom Cari --}}
                <div class="col-md-2 col-sm-2 d-flex">
                      <input class="form-control form-control-sm" type="text" placeholder="Cari Data..." wire:model.live.debounce.300ms="cari"> 
                </div>

                   {{-- Pagination --}}
            <div class="col-md-1 col-sm-1 d-flex">
                <select wire:model.live="paginate" name="paginate" id="paginate" class="form-control form-control-sm rounded-md shadow-sm">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-3 d-flex">
                <select wire:model.live="orderby" name="orderby" id="orderby" class="form-control form-control-sm rounded-md shadow-sm">
                    <option selected value="id">Urutan Default</option>
                    <option value="nama">Nama</option>
                </select>
                <select wire:model.live="asc" name="asc" id="asc" class="form-control form-control-sm rounded-md shadow-sm">
                  <option value="ASC">Terkecil</option>
                  <option value="DESC">Terbesar</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-3 d-flex">
                <div class="d-grid btn-group" role="group">
                  @if ($checked)
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Aksi ({{count($checked)}})
                  </button>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#" onclick="confirm('Yakin Ingin Menghapus {{ count($checked) }} Data ?')||event.stopImmediatePropagation()" wire:click="deleteDatas()">Delete ({{ count($checked) }})</a></li>           
                  </ul>
                  @endif
                </div>
              </div>

              <div class="col-md-3 col-sm-3 d-flex">

                @if ($isFormVisible)
                  <button type="button" class="btn btn-danger" wire:click="hideForm"> <i class="bi bi-x-lg"></i> Tutup</button>
                @else
                <button type="button" class="btn btn-primary" wire:click="showForm"> <i class="bi bi-plus-lg"></i>
                  Tambah Pokja
                </button>
                @endif
            </div>
          
        </div>
        
        @if ($isFormVisible)
        <div class="container mt-3">

            <h5 class="mb-3" >Tambah Pokja</h5>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <label for="namakategori">Nama Pokja</label>
                        <input  type="text" wire:model = "nama" class="form-control {{$errors->first('nama') ? "is-invalid" : "" }}" id="namakategori" placeholder="Isikan Nomor Pokja...." >
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-6">
                        <label for="namakategori">Nomor</label>
                        <input  type="number" wire:model = "nomor" class="form-control {{$errors->first('nomor') ? "is-invalid" : "" }}" id="nomorkategori" placeholder="Isikan Nomor Pokja...." >
                        @error('nomor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="statuskategori">Status</label>
                        <select class="form-select" aria-label="Default select example" wire:model='status' id="statuskategori">
                            <option selected>Pilih Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                          </select>
                        @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="text-center mt-3 mb-3">
                    <button type="button" class="btn btn-primary" wire:click="saveData">Save</button>
                </div>
    
        </div>
        @endif
            
            @if ($selectPage)
                <div class="col-md-10 my-3">
                @if ($selectAll)
                Anda Telah Memilih <strong>Seluruh Data ({{ $categories->total() }} Data)</strong>
                <a href="#" role="button" class="badge bg-success" wire:click="selectPart" style="text-decoration: none">Pilih Yang Ditampilkan Saja</a>
                @else
                Anda Telah Memilih <strong>{{ count($checked) }} Data</strong>, Apakah Anda Ingin Memilih Seluruh Data <strong>({{ $categories->total() }} Data)</strong> ?
                <a href="#" role="button" class="badge bg-primary" wire:click="selectAllData" style="text-decoration: none">Pilih Semua</a>
                @endif
                </div>         
            @endif

         
            
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th><input type="checkbox" wire:model.live="selectPage"></th>
                          <th class="text-center">No</th>
                          <th class="text-center" >Nama</th>
                          <th class="text-center" >No Pokja</th>
                          <th class="text-center" >Status</th>
                          <th class="text-center">Aksi</th>  
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($categories as $category)
                        <div wire:key='{{ $category->id }}'>
                            <tr class="@if ($this->isChecked($category->id)) table-primary @endif"> 
                                <td><input type="checkbox" value="{{ $category->id }}" wire:model.live="checked">
                                    @if ($editedcategoryIndex == $category->id)
                                    @endif</td>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if ($editedcategoryIndex !== $category->id)
                                    
                                    {{ $category->nama }}
                                    
                                    @else
                                    <input  type="text" wire:model ="setcategories.{{$category->id}}.nama" class="form-control
                                        {{$errors->first('nama') ? "is-invalid" : "" }}" id="nama">                                
                                        @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    @endif
                                   
                                    
                                    
                                </td>


                                <td class="text-center">
                                    @if ($editedcategoryIndex !== $category->id)
                                    
                                    {{ $category->nomor }}
                                    
                                    @else
                                    <input  type="text" wire:model ="setcategories.{{$category->id}}.nomor" class="form-control
                                        {{$errors->first('nomor') ? "is-invalid" : "" }}" id="nomor">                                
                                        @error('nomor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    @endif
                                   
                                    
                                    
                                </td>

                                <td class="text-center">
                                    @if ($editedcategoryIndex !== $category->id)
                                    
                                    {{ $category->status }}
                                    
                                    @else
                                    <select class="form-select" aria-label="Default select example" wire:model="setcategories.{{$category->id}}.status" id="status">
                                        <option>Pilih Status</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak aktif">Tidak Aktif</option>
                                      </select>                             
                                        @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    @endif
                                   
                                    
                                    
                                </td>
                                
                                <td class="text-center col-3">
                                    <a class="btn btn-outline-primary" href="{{ route('categorydashboard', $category->slug) }}"><i class="bi bi-eye-fill"></i></a>
                                    @if (!$checked)
                                        @if ($editedcategoryIndex !== $category->id)
                                            <a class="btn btn-outline-warning" wire:click.prevent="editcategory({{ $category->id }})">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline-warning" wire:click.prevent="savecategory({{ $category->id }})">
                                                <i class="bi bi-sd-card-fill"></i>
                                            </button>
                                        @endif
                                    {{-- <a class="btn btn-outline-warning" href=""><i class="bi bi-pencil-fill"></i></i></a> --}}
                                    @endif
                                    @if (!$checked)
                                    <a class="btn btn-outline-danger"
                                    onclick="confirm('Apakah Yakin Ingin Menghapus Data Kategori {{ $category->nama }}  ?')||event.stopImmediatePropagation()"
                                    wire:click="deleteSatuData({{$category->id}})" ><i class="bi bi-trash-fill"></i></a>    
                                    @endif
                      
                                </td>
                            </tr>
                        </div>
                        @endforeach
                      </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12">
                  {{ count($categories) }} dari {{ $categories->total() }}
                </div>
                <div class="col-sm-12">
                  {{ $categories->links() }}
                </div>
              </div>
        </div>



    
</div>
