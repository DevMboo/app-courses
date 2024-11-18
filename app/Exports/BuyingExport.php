<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Carbon\Carbon;

class BuyingExport implements FromCollection, WithHeadings, WithMapping {

    protected $buying;

    public function __construct($buying)
    {
        $this->buying = $buying;
    }

    public function collection()
    {
        return $this->buying;
    }

    public function headings(): array
    {
        return [
            'Email',
            'CPF',
            'Curso',
            'Preço',
            'Status',
            'Criado em',
        ];
    }

    public function map($buying): array
    {
        return [
            $buying->email,
            $buying->cpf,
            $buying->course->title,
            $buying->course->price,
            $buying->status,
            $buying->created_at ? Carbon::parse($buying->created_at)->format('d/m/Y H:i') : '',
        ];
    }

}
