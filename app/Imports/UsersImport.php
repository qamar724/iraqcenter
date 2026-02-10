<?php
// filepath: app/Imports/UsersImport.php

namespace App\Imports;

use App\Models\Admin\doctors_model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    protected int $createdBy;
    public Collection $rows;

    public function __construct(int $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Capture rows; insertion handled in controller via foreach.
     */
    public function collection(Collection $rows)
    {
        $this->rows = $rows;
    }
}
