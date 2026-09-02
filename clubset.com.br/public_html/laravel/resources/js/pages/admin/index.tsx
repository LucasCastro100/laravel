import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { index as adminIndex, moderation } from '@/routes/admin';
import { Head } from '@inertiajs/react';
import {
    AlertTriangle,
    ArrowRightLeft,
    Clock,
    Coins,
    List,
    ShieldCheck,
    Users,
} from 'lucide-react';

interface Metrics {
    users: {
        total: number;
        videomakers: number;
        clients: number;
        companies: number;
        unverified: number;
    };
    listings: {
        total: number;
        pending: number;
        active: number;
    };
    matches: {
        total: number;
        pending: number;
        completed: number;
    };
    disputes: {
        open: number;
    };
    credits: {
        in_circulation: number;
    };
}

interface PendingListing {
    id: number;
    title: string;
    region: string;
    ownerName: string;
    createdAt: string;
}

interface OpenDispute {
    id: number;
    reason: string;
    createdAt: string;
}

interface AdminIndexProps {
    metrics: Metrics;
    pendingListings: PendingListing[];
    openDisputes: OpenDispute[];
}

export default function AdminIndex({
    metrics,
    pendingListings,
    openDisputes,
}: AdminIndexProps) {
    const metricCards = [
        {
            label: 'Usuarios',
            value: metrics.users.total,
            icon: Users,
            detail: `${metrics.users.videomakers} videomakers, ${metrics.users.clients} clientes, ${metrics.users.companies} empresas`,
        },
        {
            label: 'Nao verificados',
            value: metrics.users.unverified,
            icon: ShieldCheck,
            detail: 'Aguardando validacao',
            variant:
                metrics.users.unverified > 0 ? 'text-amber-500' : undefined,
        },
        {
            label: 'Anuncios',
            value: metrics.listings.total,
            icon: List,
            detail: `${metrics.listings.pending} pendentes, ${metrics.listings.active} ativos`,
        },
        {
            label: 'Matches',
            value: metrics.matches.total,
            icon: ArrowRightLeft,
            detail: `${metrics.matches.pending} pendentes, ${metrics.matches.completed} concluidos`,
        },
        {
            label: 'Disputas abertas',
            value: metrics.disputes.open,
            icon: AlertTriangle,
            detail: 'Em andamento',
            variant: metrics.disputes.open > 0 ? 'text-destructive' : undefined,
        },
        {
            label: 'Creditos em circulacao',
            value: `R$ ${metrics.credits.in_circulation.toFixed(2)}`,
            icon: Coins,
            detail: 'Total emitido',
        },
    ];

    return (
        <>
            <Head title="Painel Admin" />

            <div className="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4 md:p-6">
                <h1 className="text-lg font-semibold">Painel Admin</h1>

                <div className="grid auto-rows-min gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    {metricCards.map((metric) => (
                        <Card key={metric.label}>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium text-muted-foreground">
                                    {metric.label}
                                </CardTitle>
                                <metric.icon
                                    className={`size-4 text-muted-foreground ${metric.variant ?? ''}`}
                                />
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
                    <Card className="gap-4">
                        <CardHeader className="flex flex-row items-center justify-between space-y-0">
                            <CardTitle className="text-sm font-semibold">
                                Anúncios pendentes
                            </CardTitle>
                            <Button variant="outline" size="sm" asChild>
                                <a href={moderation.url()}>Ver todos</a>
                            </Button>
                        </CardHeader>
                        <CardContent>
                            {pendingListings.length === 0 ? (
                                <div className="rounded-xl border border-sidebar-border/70 p-8 text-center text-sm text-muted-foreground dark:border-sidebar-border">
                                    Nenhum anúncio pendente.
                                </div>
                            ) : (
                                <div className="space-y-2">
                                    {pendingListings.map((listing) => (
                                        <div
                                            key={listing.id}
                                            className="flex items-center justify-between rounded-xl border border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                                        >
                                            <div>
                                                <p className="text-sm font-medium">
                                                    {listing.title}
                                                </p>
                                                <p className="text-xs text-muted-foreground">
                                                    {listing.ownerName} -{' '}
                                                    {listing.region}
                                                </p>
                                            </div>
                                            <div className="flex items-center gap-3">
                                                <Badge variant="secondary">
                                                    <Clock className="size-3" />{' '}
                                                    Pendente
                                                </Badge>
                                                <span className="text-xs text-muted-foreground">
                                                    {listing.createdAt}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    <Card className="gap-4">
                        <CardHeader>
                            <CardTitle className="text-sm font-semibold">
                                Disputas abertas
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            {openDisputes.length === 0 ? (
                                <div className="rounded-xl border border-sidebar-border/70 p-8 text-center text-sm text-muted-foreground dark:border-sidebar-border">
                                    Nenhuma disputa aberta.
                                </div>
                            ) : (
                                <div className="space-y-2">
                                    {openDisputes.map((dispute) => (
                                        <div
                                            key={dispute.id}
                                            className="flex items-center justify-between rounded-xl border border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                                        >
                                            <div>
                                                <p className="text-sm font-medium">
                                                    Disputa #{dispute.id}
                                                </p>
                                                <p className="text-xs text-muted-foreground">
                                                    {dispute.reason}
                                                </p>
                                            </div>
                                            <span className="text-xs text-muted-foreground">
                                                {dispute.createdAt}
                                            </span>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </>
    );
}

AdminIndex.layout = {
    breadcrumbs: [
        {
            title: 'Painel Admin',
            href: adminIndex(),
        },
    ],
};
