<?php

namespace App\Client\WeatherBit\Entity\HistoryDaily\Dto\Output;

class CurrentWeatherDTO
{
    public function __construct(
        public readonly float $appTemp,
        public readonly int $aqi,
        public readonly string $cityName,
        public readonly int $clouds,
        public readonly string $countryCode,
        public readonly string $datetime,
        public readonly float $dewpt,
        public readonly int $dhi,
        public readonly int $dni,
        public readonly float $elevAngle,
        public readonly int $ghi,
        public readonly float $gust,
        public readonly int $hAngle,
        public readonly float $lat,
        public readonly float $lon,
        public readonly string $obTime,
        public readonly string $pod,
        public readonly float $precip,
        public readonly float $pres,
        public readonly int $rh,
        public readonly int $slp,
        public readonly float $snow,
        public readonly int $solarRad,
        /** @var list<string> */
        public readonly array $sources,
        public readonly string $stateCode,
        public readonly string $station,
        public readonly string $sunrise,
        public readonly string $sunset,
        public readonly float $temp,
        public readonly string $timezone,
        public readonly int $ts,
        public readonly int $uv,
        public readonly float $vis,
        /** @var array{description: string, code: int, icon: string} */
        public readonly array $weather,
        public readonly string $windCdir,
        public readonly string $windCdirFull,
        public readonly int $windDir,
        public readonly float $windSpd,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            appTemp: (float) $data['app_temp'],
            aqi: (int) $data['aqi'],
            cityName: (string) $data['city_name'],
            clouds: (int) $data['clouds'],
            stateCode: (string) $data['state_code'],
            countryCode: (string) $data['country_code'],
            datetime: (string) $data['datetime'],
            dewpt: (float) $data['dewpt'],
            dhi: (int) $data['dhi'],
            dni: (int) $data['dni'],
            elevAngle: (float) $data['elev_angle'],
            ghi: (int) $data['ghi'],
            gust: (float) $data['gust'],
            hAngle: (int) $data['h_angle'],
            timezone: (string) $data['timezone'],
            lat: (float) $data['lat'],
            lon: (float) $data['lon'],
            obTime: (string) $data['ob_time'],
            pod: (string) $data['pod'],
            precip: (float) $data['precip'],
            pres: (float) $data['pres'],
            rh: (int) $data['rh'],
            slp: (int) $data['slp'],
            snow: (float) $data['snow'],
            solarRad: (int) $data['solar_rad'],
            sources: array_values(array_map('strval', $data['sources'] ?? [])),
            station: (string) $data['station'],
            sunrise: (string) $data['sunrise'],
            sunset: (string) $data['sunset'],
            temp: (float) $data['temp'],
            ts: (int) $data['ts'],
            uv: (int) $data['uv'],
            vis: (float) $data['vis'],
            weather: [
                'description' => (string) $data['weather']['description'],
                'code' => (int) $data['weather']['code'],
                'icon' => (string) $data['weather']['icon'],
            ],
            windCdir: (string) $data['wind_cdir'],
            windCdirFull: (string) $data['wind_cdir_full'],
            windDir: (int) $data['wind_dir'],
            windSpd: (float) $data['wind_spd'],
        );
    }
}