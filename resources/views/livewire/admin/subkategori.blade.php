<div>
    <div>
        <div class="container">
            <h2 class="mb-3 text-lg font-large leading-6 text-gray-900">Data Kategori</h2>
    
            <div class="row mb-2">
                    {{-- Kolom Cari --}}
                <div class="col-md-3 col-sm-3 d-flex">
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
                        <option value="category_id">Kategori</option>
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

                <div class="col-md-2 col-sm-2 d-flex">

                    @if ($isFormVisible)
                    <button type="button" class="btn btn-danger" wire:click="hideForm"> <i class="bi bi-x-lg"></i> Tutup</button>
                    @else
                    <button type="button" class="btn btn-primary" wire:click="showForm"> <i class="bi bi-plus-lg"></i>
                    Tambah
                    </button>
                    @endif
                </div>
          
            </div>
            @if ($isFormVisible)
            <div class="container mt-5">

                <h5 class="mb-3" >Tambah Sub Pokja</h5>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label for="nama">Nama Sub Pokja</label>
                            <input  type="text" wire:model = "nama" class="form-control {{$errors->first('nama') ? "is-invalid" : "" }}" id="nama" placeholder="Isikan Nama Kategori...." >
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-6" wire:ignore>
                            <label for="select2">Pokja</label>
                            <select class="form-select mb-3 {{$errors->first('selected') ? "is-invalid" : "" }} select2" id="select2" wire:model='category_id' name="category_id">
                              <option selected readonly>Pilih Pokja</option>
                              @foreach ($categories as $category)
                                  <option value="{{ $category->id }}">{{ $category->nama }}</option>
                              @endforeach
                   
                            </select>
      
                            @error('selected')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
      
                          </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-primary" wire:click = "submit" type="submit">Kirim</button>
                    </div>
            </div>
            @endif

            
            @if ($selectPage)
                <div class="col-md-10 my-3">
                @if ($selectAll)
                Anda Telah Memilih <strong>Seluruh Data ({{ $subcategories->total() }} Data)</strong>
                <a href="#" role="button" class="badge bg-success" wire:click="selectPart" style="text-decoration: none">Pilih Yang Ditampilkan Saja</a>
                @else
                Anda Telah Memilih <strong>{{ count($checked) }} Data</strong>, Apakah Anda Ingin Memilih Seluruh Data <strong>({{ $subcategories->total() }} Data)</strong> ?
                <a href="#" role="button" class="badge bg-primary" wire:click="selectAllData" style="text-decoration: none">Pilih Semua</a>
                @endif
                </div>         
            @endif
            
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th><input type="checkbox" wire:model.live="selectPage"></th>
                          <th class="text-center col-1">No</th>
                          <th class="text-center col-5" >Sub Pokja</th>
                          <th class="text-center col-4" >Pokja</th>
                          <th class="text-center col-3">Aksi</th>  
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($subcategories as $subcategory) 
                            <tr class="@if ($this->isChecked($subcategory->id)) table-primary @endif" wire:key='{{ $subcategory->id }}'> 
                                <td><input type="checkbox" value="{{ $subcategory->id }}" wire:model.live="checked">
                                    @if ($editedSubcategoryIndex == $subcategory->id) @endif</td>
                                <td class="text-center col-1">{{ $loop->iteration }}</td>
                                <td class="text-center col-5">
                                    @if ($editedSubcategoryIndex !== $subcategory->id)
                                    
                                    {{ $subcategory->nama }}
                                    
                                    @else
                                    <input  type="text" wire:model ="setsubcategories.{{$subcategory->id}}.nama" class="form-control
                                        {{$errors->first('nama') ? "is-invalid" : "" }}" id="nama">                                
                                        @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    @endif
                                   

                                </td>
                                <td class="text-center col-4">
                                    @if ($editedSubcategoryIndex !== $subcategory->id)
                                    
                                        {{ $subcategory->categories->nama }}
                                    
                                    @else
                                        <select class="form-select mb-3 {{$errors->first('selected') ? "is-invalid" : "" }}" wire:model.live = "setsubcategories.{{ $subcategory->id}}.category_id">
                                            <option selected readonly>Pilih Pokja</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                                        @endforeach
                            
                                        </select>
                
                                        @error('selected')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    @endif
                                </td>

                                <td class="text-center col-3">
                                    <a class="btn btn-outline-primary" href=""><i class="bi bi-eye-fill"></i></a>
                                    @if (!$checked)
                                        @if ($editedSubcategoryIndex !== $subcategory->id)
                                            <a class="btn btn-outline-warning" wire:click.prevent="editSubcategory({{ $subcategory->id }})">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline-warning" wire:click.prevent="saveSubcategory({{ $subcategory->id }})">
                                                <i class="bi bi-sd-card-fill"></i>
                                            </button>
                                        @endif
                                    {{-- <a class="btn btn-outline-warning" href=""><i class="bi bi-pencil-fill"></i></i></a> --}}
                                    @endif
                                    @if (!$checked)
                                    <a class="btn btn-outline-danger"
                                    onclick="confirm('Apakah Yakin Ingin Menghapus Data Survei Judul {{ $subcategory->nama }} Yang Berkategori {{ $subcategory->categories->nama }}  ?')||event.stopImmediatePropagation()"
                                    wire:click="deleteSatuData({{$subcategory->id}})" ><i class="bi bi-trash-fill"></i></a>    
                                    @endif
                      
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                  {{ count($subcategories) }} dari {{ $subcategories->total() }}
                </div>
                <div class="col-sm-12">
                  {{ $subcategories->links() }}
                </div>
              </div>
        </div>

    </div>
</div>

@push('select2')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   
    $(document).ready(function() {
    $('#select2').select2();
            $('#select2').on('change', function (e) {
                var data = $('#select2').select2("val");
            @this.set('category_id', data);
            });
});
</script>

@endpush
