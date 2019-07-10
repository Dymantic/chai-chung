<?php

namespace App\Reports;

use App\Clients\Client;
use Illuminate\Database\Eloquent\Model;

class ClientCostEntry extends Model
{
    protected $fillable = ['client_id', 'total_hours', 'overtime_hours', 'annual_revenue', 'cost'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client->id,
            'client_code' => $this->client->client_code,
            'client_name' => $this->client->name,
            'total_hours' => $this->total_hours,
            'overtime_hours' => $this->overtime_hours,
            'annual_revenue' => $this->annual_revenue,
            'cost' => $this->cost,
        ];
    }
}
