<?php

namespace App\Exports;

use App\Models\License;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class LicensesExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $status;
    protected $startDate;
    protected $endDate;

    public function headings(): array
    {
        return [
            '#',
            'Folio',
            'Propietario',
            'DRO',
            'Calle',
            'Número',
            'Colonia',
            'Sup. Construida',
            'Observaciones',
            'Clave Catastral',
            'Vigencia',
            'No. Recibo',
            'Concepto',
        ];
    }

    public function forStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    public function forDates(string $startDate = null, string $endDate = null)
    {
        //casting string to carbon date
        $this->startDate = new \Carbon\Carbon($startDate ?? '2019-01-01');
        $this->endDate = new \Carbon\Carbon($endDate ?? now()->format('Y-m-d'));

        return $this;
    }

    public function query()
    {
        return License::query()
            ->where('estatus', $this->status)
            ->whereBetween('fecha_registro', [$this->startDate, $this->endDate])
            ->with('applicant')
            ->with('construction')
            ->with('owner')
            ->with('order')
            ->orderBy('licenses.id', 'desc');
    }

    /**
    * @var License $invoice
    */
    public function map($license): array
    {
        $rows = [
            $license->id,
            $license->folio,
            $license->owner->nombre_apellidos,
            $license->applicant->nombre,
            $license->property->calle,
            $license->property->no,
            $license->property->colonia,
            $license->construction->sup_total_amp_reg_const ?? 0,
            'Observaciones',
            $license->property->clave_catastral,
            $license->validity->fecha_autorizacion . ' - ' . $license->validity->fecha_fin_vigencia,
            $license->order->no_ref_pago,
            $license->construction->descripcion,
        ];

        return $rows;
    }
}
