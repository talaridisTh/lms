<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;


class UsersExportView implements FromQuery,WithMapping,WithHeadings,WithEvents  {

    protected $id;


    function __construct($id)
    {

        $this->id = $id;
    }

    public function query()
    {

        $ids = explode(',', $this->id);

        return User::whereIn("id", $ids);
    }

    public function map($user): array
    {

        $decryptPassword = Crypt::decryptString($user->password_encrypt);
        $course = $user->courses->map(function ($course){
            return $course->title;
        });

        return [
            $user->first_name,
            $user->last_name,
            $user->email,
            $decryptPassword,
            $course->implode(' - ')

        ];
    }
//
    public function headings(): array
    {
        return [
            'Όνομα',
            'Επώνυμο ',
            'Ε-mail',
            'Κωδικό ',
            'Courses',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
                $columns =  ["A","B","C","D","F","E"];

                foreach ($columns as $column){
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },



        ];
    }

}


