<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class BrandExport implements FromCollection, WithHeadings
{
    protected $brandIds;

    public function __construct($brandIds)
    {
        $this->brandIds = $brandIds;
    }

    public function collection()
    {
        // If specific IDs are provided, export only those brands
        if ($this->brandIds) {
            return Brand::whereIn('id', $this->brandIds)
                ->get([ 'code', 'name', 'image', 'slug', 'description']);
        }

        // Otherwise, export all brands
        return Brand::all([ 'code', 'name', 'image', 'slug', 'description']);
    }

    public function headings(): array
    {
        return [ 'Code', 'Name', 'Image', 'Slug', 'Description'];
    }
}

