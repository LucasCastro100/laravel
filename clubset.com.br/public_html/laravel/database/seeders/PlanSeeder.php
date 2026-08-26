<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Seed the application's subscription plans.
     *
     * Os planos "pro" e "max" precisam de um Stripe Price ID criado no
     * dashboard do Stripe (Produto + Preço recorrente mensal). Após criar,
     * preencha o campo stripe_price_id abaixo.
     */
    public function run(): void
    {
        Plan::query()->updateOrCreate(
            ['slug' => 'trial'],
            [
                'name' => 'Trial',
                'description' => 'Comece grátis e explore a plataforma sem custo.',
                'stripe_price_id' => null,
                'price' => 0,
                'currency' => 'brl',
                'trial_days' => 0,
                'features' => [
                    'Perfil público',
                    'Publicação de anúncios de equipamento',
                    'Permuta bilateral',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
        );

        Plan::query()->updateOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Pro',
                'description' => 'Para videomakers e empresas que querem crescer.',
                'stripe_price_id' => env('STRIPE_PRICE_PRO'),
                'price' => 99.9,
                'currency' => 'brl',
                'trial_days' => 7,
                'features' => [
                    'Tudo do Trial',
                    'Match por região e especialidade',
                    'Permuta multilateral com crédito',
                    'Anúncios em destaque',
                    'Estatísticas de perfil',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
        );

        Plan::query()->updateOrCreate(
            ['slug' => 'max'],
            [
                'name' => 'Max',
                'description' => 'Para quem vive de audiovisual e maximiza oportunidades.',
                'stripe_price_id' => env('STRIPE_PRICE_MAX'),
                'price' => 199.9,
                'currency' => 'brl',
                'trial_days' => 7,
                'features' => [
                    'Tudo do Pro',
                    'Sem limites de anúncios',
                    'Prioridade no match',
                    'Suporte prioritário',
                    'Relatórios avançados',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
        );
    }
}
