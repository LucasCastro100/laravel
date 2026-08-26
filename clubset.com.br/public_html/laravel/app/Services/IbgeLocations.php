<?php

namespace App\Services;

use App\Models\Municipality;
use App\Models\State;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Fetches Brazilian states and municipalities from the public IBGE
 * "Localidades" API and keeps a local copy for fast, offline-friendly selects.
 */
class IbgeLocations
{
    private const BASE_URL = 'https://servicodados.ibge.gov.br/api/v1/localidades';

    /**
     * Import (upsert) all states and municipalities from IBGE.
     *
     * @return array{states: int, municipalities: int}
     *
     * @throws RequestException
     */
    public function import(): array
    {
        $states = 0;
        $municipalities = 0;

        foreach ($this->fetchStates() as $state) {
            State::query()->updateOrCreate(
                ['ibge_code' => $state['id']],
                [
                    'name' => $state['nome'],
                    'uf' => $state['sigla'],
                    'region' => $state['regiao']['nome'],
                ],
            );

            $localState = State::query()->where('ibge_code', $state['id'])->firstOrFail();

            foreach ($this->fetchMunicipalities($state['sigla']) as $municipality) {
                Municipality::query()->updateOrCreate(
                    ['ibge_code' => $municipality['id']],
                    [
                        'name' => $municipality['nome'],
                        'state_id' => $localState->id,
                    ],
                );

                $municipalities++;
            }

            $states++;
        }

        return compact('states', 'municipalities');
    }

    /**
     * All states ordered by name.
     *
     * @return Collection<int, State>
     */
    public function states(): Collection
    {
        return State::query()->orderBy('name')->get();
    }

    /**
     * The municipalities of the given UF (e.g. "SP"), ordered by name.
     *
     * @return Collection<int, Municipality>
     */
    public function municipalities(string $uf): Collection
    {
        return Municipality::query()
            ->whereHas('state', fn ($query) => $query->where('uf', strtoupper($uf)))
            ->orderBy('name')
            ->get();
    }

    /**
     * @return array<int, array{id: int, sigla: string, nome: string, regiao: array{nome: string}}>
     */
    private function fetchStates(): array
    {
        return Http::retry(3, 500)->acceptJson()
            ->get(self::BASE_URL.'/estados?orderBy=nome')
            ->throw()
            ->json();
    }

    /**
     * @return array<int, array{id: int, nome: string}>
     */
    private function fetchMunicipalities(string $uf): array
    {
        return Http::retry(3, 500)->acceptJson()
            ->get(self::BASE_URL.'/estados/'.$uf.'/municipios')
            ->throw()
            ->json();
    }
}
