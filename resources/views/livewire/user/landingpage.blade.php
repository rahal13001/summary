<div>
  <div class="container mt-4">
    <h1 class="app-page-title">Halo {{ Auth::user()->name }}</h1>
  </div>

    {{-- Card info --}}

    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-4">
          <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
              <h4 class="stats-type mb-1">Sumarry Ku</h4>
              <div class="stats-figure">{{ $summary_ku }}</div>
            </div>
            <!--//app-card-body-->
            <a class="app-card-link-mask" href="#"></a>
          </div>
          <!--//app-card-->
        </div>
        <!--//col-->

        <div class="col-6 col-lg-4">
          <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
              <h4 class="stats-type mb-1">Summary Tahun Ini</h4>
              <div class="stats-figure">{{ $summary_tahun_ini }}</div>
            </div>
            <!--//app-card-body-->
            <a class="app-card-link-mask" href="#"></a>
          </div>
          <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-6 col-lg-4">
          <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
              <h4 class="stats-type mb-1">Summary Bulan Ini</h4>
              <div class="stats-figure">{{ $summary_bulan_ini }}</div>
            </div>
            <!--//app-card-body-->
            <a class="app-card-link-mask" href="#"></a>
          </div>
          <!--//app-card-->
        </div>
        <!--//col-->
      </div>
      {{-- Akhir card rekap --}}


      {{-- Grafik --}}
        <div class="row g-4 mb-4">
            <!--//col-->
            <div class="col-12 col-lg-6">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                        <h4 class="app-card-title">Rekap Summary Per IKU</h4>
                        </div>
                        <!--//col-->
                        <div class="col-auto">
                        <div class="card-header-action">
                       
                        </div>
                        <!--//card-header-actions-->
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                    </div>
                    <!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                    <div class="row">
                        <div class="mb-3 col-3 d-flex">
                            <select
                            class="form-select form-select-sm ms-auto d-inline-flex w-auto"
                            wire:model.live = 'waktuiku'
                            >
                            <option value="1" selected>Tahun Ini</option>
                            <option value="2">Bulan Ini</option>
                            <option value="3">Minggu Ini</option>
                            <option value="4">Hari Ini</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3 mx-2 d-flex">
                            <select
                            class="form-select form-select-sm ms-auto d-inline-flex w-auto"
                            wire:model.live ='ikuUser'>
                            <option value= "false" selected>Semua</option>
                            <option value="true">Data Saya</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="chart-container" style="height: 20rem">
                      <livewire:livewire-column-chart
                      key="{{ $columnChartModel->reactiveKey() }}"
                      :column-chart-model="$columnChartModel"/>
                  </div>
                    
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
                </div>
            <!--//col-->

            <div class="col-12 col-lg-6">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                        <h4 class="app-card-title">Rekap Summary Per Pokja</h4>
                        </div>
                        <!--//col-->
                        <div class="col-auto">
                        <div class="card-header-action">
                       
                        </div>
                        <!--//card-header-actions-->
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                    </div>
                    <!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                    <div class="row">
                        <div class="mb-3 col-3 d-flex">
                            <select
                            class="form-select form-select-sm ms-auto d-inline-flex w-auto"
                            wire:model.live = 'waktupokja'
                            >
                            <option value="1" selected>Tahun Ini</option>
                            <option value="2">Bulan Ini</option>
                            <option value="3">Minggu Ini</option>
                            <option value="4">Hari Ini</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3 mx-2 d-flex">
                            <select
                              class="form-select form-select-sm ms-auto d-inline-flex w-auto"
                              wire:model.live='categoryUser'
                            >
                            <option value= "false" selected>Semua</option>
                            <option value="true">Data Saya</option>
                            </select>
                        </div>
                    </div>
              
                    
                    <div class="chart-container" style="height: 20rem">
                        <livewire:livewire-column-chart
                        key="{{ $pokjacolumnChartModel->reactiveKey() }}"
                        :column-chart-model="$pokjacolumnChartModel"/>
                    </div>
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
                </div>
                <!--//col-->
        </div>
      {{-- Akhir grafik --}}






      {{-- Topscrorer --}}
      <div class="row g-4 mb-4">
        {{-- Top score tahunan --}}
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-stats-table h-100 shadow-sm">
              <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto">
                    <h4 class="app-card-title">Top Writer This Year !!!</h4>
                  </div>
                  <!--//col-->
              
                  <!--//col-->
                </div>
                <!--//row-->
              </div>
              <!--//app-card-header-->
              <div class="app-card-body p-3 p-lg-4">
                <div class="table-responsive">
                  <table class="table table-borderless mb-0">
                    <thead>
                      <tr>
                        
                          <th class="meta">Nama</th>
                          <th class="meta stat-cell">Jumlah</th>
                   
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($yearlyLeaderBoards as $tahunan)
                      <tr>
                        <td><a href="#">{{ $tahunan->user->name }}</a></td>
                        <td class="stat-cell">{{ $tahunan->report_count }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!--//table-responsive-->
              </div>
              <!--//app-card-body-->
            </div>
            <!--//app-card-->
          </div>
        {{-- Akhir top score tahunan --}}
        {{-- Topscore bulanan --}}
        <div class="col-12 col-lg-6">
          <div class="app-card app-card-stats-table h-100 shadow-sm">
            <div class="app-card-header p-3">
              <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                  <h4 class="app-card-title">Top Writer This Month !!!</h4>
                </div>
                <!--//col-->
                <!--//col-->
              </div>
              <!--//row-->
            </div>
            <!--//app-card-header-->
            <div class="app-card-body p-3 p-lg-4">
              <div class="table-responsive">
                <table class="table table-borderless mb-0">
                  <thead>
                    <tr>
                      <th class="meta">Nama</th>
                      <th class="meta stat-cell">Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($monthlyLeaderBoards as $bulanan)
                      <tr>
                        <td><a href="#">{{ $bulanan->user->name }}</a></td>
                        <td class="stat-cell">{{ $bulanan->report_count }}</td>
                      </tr>
                    @endforeach
                 
                  </tbody>
                </table>
              </div>
              <!--//table-responsive-->
            </div>
            <!--//app-card-body-->
          </div>
          <!--//app-card-->
        </div>
        {{-- Akhir topscore bulanan --}}
        <!--//col-->
      </div>
      {{-- end topscor --}}
    
</div>