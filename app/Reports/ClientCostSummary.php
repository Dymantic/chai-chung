<?php


namespace App\Reports;


use App\Clients\Client;

class ClientCostSummary
{
    private $start;
    private $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function toArray()
    {
        return [
            'start' => $this->start->format('Y-m-d'),
            'end' => $this->end->format('Y-m-d'),
            'clients' => $this->clientSummaries()
        ];
    }

    public function save()
    {
        $report = ClientCostReport::create([
            'start_date' => $this->start,
            'end_date' => $this->end
        ]);

        collect($this->clientSummaries())->each(function($client) use ($report) {
            $report->entries()->create([
                'client_id' => $client['id'],
                'total_hours' => $client['total_hours'],
                'overtime_hours' => $client['overtime_hours'],
                'cost' => $client['cost'],
                'annual_revenue' => $client['annual_revenue'],
            ]);
        });
    }

    private function clientSummaries()
    {
        $clients = Client::with('sessions', 'sessions.user')->get();

        return $clients
            ->map(function($client) {
                $sessions = $client
                    ->sessions()
                    ->with('user')
                    ->whereBetween('start_time', [$this->start->startOfDay(), $this->end->endOfDay()])
                    ->get();
                return [
                    'id' => $client->id,
                    'code' => $client->client_code,
                    'name' => $client->name,
                    'total_hours' => $sessions->sum(function($s) {return $s->duration()->minutes() / 60; }),
                    'overtime_hours' => $sessions->sum(function($s) {return $s->overtime_minutes / 60; }),
                    'cost' => $sessions->sum(function($s) {return $s->cost(); }),
                    'annual_revenue' => $client->annual_revenue,
                ];
            })->values()->all();
    }
}