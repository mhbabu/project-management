<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectReportExport implements FromCollection, WithColumnWidths, WithMapping, WithHeadings, WithEvents, WithStyles
{
    use Exportable;

    private $params;

    /**
     * @param Request $request
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return Project::whereBetween('created_at', [$this->params['start_date'], $this->params['end_date']]);   
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->query()->get();
    }


    /**
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->teamLeader->name,
            $row->tasks->count(),
            $row->totalSubtasks(),
        ];
    }

    public function headings(): array
    {
        return [
            'Project Name',
            'Team Leader',
            'Total Tasks',
            'Total Subtasks'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 15,
            'D' => 15
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:M')
                    ->getAlignment();
//                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

