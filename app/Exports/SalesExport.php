<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $query = Sale::with('items');
        if ($this->ids) {
            $query->whereIn('id', $this->ids);
        }
        return $query->get()->map(function ($sale) {
            return [
                // 'id' => $sale->id,
                'customer' => $sale->customer_id ?? 'N/A',
                'status' => $sale->status,
                'date' => $sale->date,
                'item_count' => $sale->items->count(),
                'total_quantity' => $sale->items->sum('quantity'),
                'total_amount' => $sale->total_amount,

            ];
        });
    }

    public function headings(): array
    {
        return [
            // 'ID',
            __('messages.customer'),
            __('messages.status'),
            __('messages.date'),
            __('messages.item_count'),
            __('messages.total_quantity'),
            __('messages.total_amount'),

        ];
    }
}
