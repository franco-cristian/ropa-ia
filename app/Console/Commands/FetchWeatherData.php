<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Climate;
use Carbon\Carbon;

class FetchWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather data from Open-Meteo API for the next 7 days and store it.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Fetching hourly weather data...');

        // En el futuro, esto debería iterar sobre una tabla de ciudades.
        $cities = [
            ['name' => 'Formosa', 'latitude' => -26.18, 'longitude' => -58.17],
        ];

        foreach ($cities as $city) {
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $city['latitude'],
                'longitude' => $city['longitude'],
                'hourly' => 'temperature_2m,relative_humidity_2m,precipitation',
                'forecast_days' => 7
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();
                $hourly = $weatherData['hourly'];

                // Creamos un diccionario para agrupar las horas por día
                $dataByDay = [];
                foreach ($hourly['time'] as $index => $datetime) {
                    $date = Carbon::parse($datetime)->toDateString();
                    if (!isset($dataByDay[$date])) {
                        // Inicializamos los arrays para este día
                        $dataByDay[$date] = [
                            'time' => [],
                            'temperature_2m' => [],
                            'relative_humidity_2m' => [],
                            'precipitation' => [],
                        ];
                    }
                    // Agregamos los datos de la hora actual al día correspondiente
                    $dataByDay[$date]['time'][] = $datetime;
                    $dataByDay[$date]['temperature_2m'][] = $hourly['temperature_2m'][$index];
                    $dataByDay[$date]['relative_humidity_2m'][] = $hourly['relative_humidity_2m'][$index];
                    $dataByDay[$date]['precipitation'][] = $hourly['precipitation'][$index];
                }

                // Ahora guardamos cada día en la base de datos
                foreach ($dataByDay as $date => $data) {
                    Climate::updateOrCreate(
                        [
                            'city' => $city['name'],
                            'date' => $date,
                        ],
                        [
                            // Guardamos la estructura 'hourly' completa para este día
                            'weather_data' => ['hourly' => $data]
                        ]
                    );
                }

                $this->info("Hourly weather data for {$city['name']} for the next 7 days updated successfully.");
            } else {
                $this->error("Failed to fetch weather data for {$city['name']}.");
            }
        }

        $this->info('All weather data processed.');
    }
}