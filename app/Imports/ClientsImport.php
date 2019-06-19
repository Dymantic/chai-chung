<?php

namespace App\Imports;

use App\Clients\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        return new Client([
            'name' => $row[1],
            'client_code' => $row[0],
            'annual_revenue' => '99'
        ]);
    }
}
