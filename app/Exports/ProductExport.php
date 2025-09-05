<?php

namespace App\Exports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class ProductExport implements FromCollection, WithHeadings
{
    protected $productIds;

    public function __construct($productIds)
    {
        $this->productIds = $productIds;
    }

    public function collection()
    {
        // If specific IDs are provided, export only those Products
        if ($this->productIds) {
            return Products::whereIn('id', $this->productIds)
                ->get([ 'code', 'name']);
        }

        // Otherwise, export all Products
        return Product::all([ 'code', 'name']);
    }

    public function headings(): array
    {
        return [ 'Code', 'Name'];
    }
}

