import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { dashboard } from '@/routes';
import { index as listingsIndex } from '@/routes/listings';
import { index as matchesIndex } from '@/routes/matches';
import { Head } from '@inertiajs/react';
import {
    Camera,
    CheckCircle2,
    Clock,
    Coins,
    Handshake,
    Repeat,
    Store,
} from 'lucide-react';

interface Metrics {
    listings: { total: number; active: number; pending: number };
    services: { total: number };
    matches: { total: number; pending: number; completed: number };
    permutas: { total: number };
    credits: { balance: number };
}

interface RecentListing {
    id: number;
    title: string;
    status: string;
    statusLabel: string;
    region: string | null;
    createdAt: string;
}

interface RecentMatch {
    id: number;
    status: string;
    statusLabel: string;
    providerName: string | null;
    listingTitle: string | null;
    createdAt: string;
}

type Props = {
    metrics: Metrics;
    recentListings: RecentListing[];
    recentMatches: RecentMatch[];
};

function statusBadge(status: string) {
    switch (status) {
        case 'active':
            return (
                <Badge
                    variant="default"
                    className="bg-green-600 hover:bg-green-700"
                >
                    Ativo
                </Badge>
            );
        case 'pending':
            return (
                <Badge variant="secondary">
                    <Clock className="size-3" /> Pendente
                </Badge>
            );
        case 'rejected':
            return <Badge variant="destructive">Recusado</Badge>;
        case 'completed':
            return (
                <Badge
                    variant="default"
                    className="bg-green-600 hover:bg-green-700"
                >
                    <CheckCircle2 className="size-3" /> Concluído
                </Badge>
            );
        default:
            return <Badge variant="secondary">{status}</Badge>;
    }
}

export default function Dashboard({
    metrics,
    recentListings,
    recentMatches,
}: Props) {
    const metricCards = [
        {
            label: 'Anúncios',
            value: metrics.listings.total,
            icon: Store,
            detail: `${metrics.listings.active} ativos, ${metrics.listings.pending} pendentes`,
        },
        {
            label: 'Serviços',
            value: metrics.services.total,
            icon: Camera,
            detail: 'Cadastrados',
        },
        {
            label: 'Matches',
            value: metrics.matches.total,
            icon: Handshake,
            detail: `${metrics.matches.completed} concluídos, ${metrics.matches.pending} pendentes`,
        },
        {
            label: 'Permutas',
            value: metrics.permutas.total,
            icon: Repeat,
            detail: 'Lanceadas',
        },
        {
            label: 'Saldo de créditos',
            value: `R$ ${metrics.credits.balance.toFixed(2)}`,
            icon: Coins,
            detail: 'Disponível',
        },
    ];

    return (
        <>
            <Head title="Painel" />

            <div className="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4 md:p-6">
                <h1 className="text-lg font-semibold">Meu Painel</h1>

                <div className="grid auto-rows-min gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                    {metricCards.map((metric) => (
                        <Card key={metric.label}>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium text-muted-foreground">
                                    {metric.label}
                                </CardTitle>
                                <metric.icon className="size-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">
                                    {metric.value}
                                </div>
                                <p className="text-xs text-muted-foreground">
                                    {metric.detail}
                                </p>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                <div className="grid gap-6 md:grid-cols-2">
                    <div className="space-y-4">
                        <div className="flex items-center justify-between">
                            <h2 className="text-sm font-semibold">
                                Meus anúncios
                            </h2>
                            <Button variant="outline" size="sm" asChild>
                                <a href={listingsIndex().url}>Ver todos</a>
                            </Button>
                        </div>
                        {recentListings.length === 0 ? (
                            <div className="rounded-xl border border-sidebar-border/70 p-8 text-center text-sm text-muted-foreground dark:border-sidebar-border">
                                Nenhum anúncio criado ainda.
                            </div>
                        ) : (
                            <div className="space-y-2">
                                {recentListings.map((listing) => (
                                    <div
                                        key={listing.id}
                                        className="flex items-center justify-between rounded-xl border border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                                    >
                                        <div>
                                            <p className="text-sm font-medium">
                                                {listing.title}
                                            </p>
                                            <p className="text-xs text-muted-foreground">
                                                {listing.region ??
                                                    'Sem localização'}
                                            </p>
                                        </div>
                                        <div className="flex items-center gap-3">
                                            {statusBadge(listing.status)}
                                            <span className="text-xs text-muted-foreground">
                                                {listing.createdAt}
                                            </span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>

                    <div className="space-y-4">
                        <div className="flex items-center justify-between">
                            <h2 className="text-sm font-semibold">
                                Meus matches
                            </h2>
                            <Button variant="outline" size="sm" asChild>
                                <a href={matchesIndex().url}>Ver todos</a>
                            </Button>
                        </div>
                        {recentMatches.length === 0 ? (
                            <div className="rounded-xl border border-sidebar-border/70 p-8 text-center text-sm text-muted-foreground dark:border-sidebar-border">
                                Nenhum match ainda.
                            </div>
                        ) : (
                            <div className="space-y-2">
                                {recentMatches.map((match) => (
                                    <div
                                        key={match.id}
                                        className="flex items-center justify-between rounded-xl border border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                                    >
                                        <div>
                                            <p className="text-sm font-medium">
                                                {match.listingTitle ??
                                                    'Anúncio'}
                                            </p>
                                            <p className="text-xs text-muted-foreground">
                                                {match.providerName ??
                                                    'Usuário'}
                                            </p>
                                        </div>
                                        <div className="flex items-center gap-3">
                                            {statusBadge(match.status)}
                                            <span className="text-xs text-muted-foreground">
                                                {match.createdAt}
                                            </span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Painel',
            href: dashboard().url,
        },
    ],
};
