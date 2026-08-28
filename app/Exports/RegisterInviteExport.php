<?php

namespace App\Exports;

use App\Models\RegisterInvite;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegisterInviteExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Fetch the data to export.
     */
    public function collection(): Enumerable
    {
        return RegisterInvite::all();
    }

    /**
     * Define Column Headers in the Excel file.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Company / Organization',
            'Position / Title',
            'Email Address',
            'Attending',
            'Notes',
            'Date Submitted',
        ];
    }

    /**
     * Map each RegisterInvite model record to Excel row values.
     */
    public function map($invite): array
    {
        // Translate confirm / attending status if needed
        $attendingStatus = match ($invite->confirm) {
            1 => 'YES',
            0 => 'NO',
            default => 'Not yet confirmed',
        };

        return [
            $invite->id,
            $invite->name,
            $invite->company,
            $invite->title,
            $invite->email,
            $attendingStatus,
            $invite->notes,
            $invite->created_at ? $invite->created_at->format('Y-m-d H:i') : '',
        ];
    }
}
