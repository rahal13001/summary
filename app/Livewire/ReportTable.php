<?php

namespace App\Livewire;

use App\Models\Report;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ReportTable extends PowerGridComponent
{
    use WithExport;
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Report::query()->with('user', 'category','indicator');
       
        
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
       
            ->addColumn('id')
            ->addColumn('when_formatted', fn (Report $model) => Carbon::parse($model->created_at)->format('d-m-Y'))
            ->addColumn('what')
            ->addColumn('user.name')
            ->addColumn('indicator.nomor_formatted', fn (Report $report) => $report->indicator->pluck('nomor')->implode(', '))
            ->addColumn('category.nomor_formatted', fn (Report $report) => $report->category->pluck('nomor')->implode(', '));
    }

    public function columns(): array
    {
        
        return [
        
            Column::make('Id', 'id'),
            Column::make('When', 'when_formatted', 'when')
                ->sortable()
                ->searchable(),
            Column::make('What', 'what')
                ->sortable()
                ->searchable(),
            
            Column::make('Penyusun', 'user.name')
                ->sortable()
                ->searchable(),

            Column::make('Nomor IKU', 'indicator.nomor_formatted', 'indicator.nomor')
                ->sortable()
                ->searchable(),

            Column::make('Nomor Pokja', 'category.nomor_formatted', 'category.nomor')
                ->sortable()
                ->searchable(),
            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('when'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(\App\Models\Report $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
