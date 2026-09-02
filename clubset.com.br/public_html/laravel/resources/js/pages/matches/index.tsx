import { EmptyState } from '@/components/empty-state';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { SearchSelect } from '@/components/ui/search-select';
import { index as matchesIndex } from '@/routes/matches';
import { show as serviceShow } from '@/routes/services';
import { Head, Link, router } from '@inertiajs/react';
import {
    AlertTriangle,
    ArrowRightLeft,
    Ban,
    Camera,
    CheckCircle2,
    Clock,
    MapPin,
    MessageSquare,
    Package,
    Search,
    Users,
    X,
    XCircle,
} from 'lucide-react';
import { useRef, useState } from 'react';

interface MatchItem {
    kind: string;
    title: string;
    url: string;
}

interface MatchDispute {
    id: number;
    status: string;
}

interface Match {
    id: number;
    status: string;
    statusLabel: string;
    tradeType: string;
    price: string;
    message: string;
    completedAt: string | null;
    createdAt: string;
    isProvider: boolean;
    counterpart: {
        id: number;
        name: string;
        region: string;
        city: string;
    };
    item: MatchItem | null;
    dispute: MatchDispute | null;
}

interface UserItem {
    id: number;
    name: string;
    region: string | null;
    city: string | null;
    services: Array<{
        id: number;
        title: string;
        specialty: string | null;
        rate: string | null;
    }>;
}

type StateOption = { id: number; name: string; uf: string };

interface MatchIndexProps {
    matches: {
        data: Match[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    users: {
        data: UserItem[];
        current_page: number;
        last_page: number;
        total: number;
    };
    filters: {
        status?: string;
    };
    states: StateOption[];
}

function statusBadge(status: string) {
    switch (status) {
        case 'pending':
            return (
                <Badge variant="secondary">
                    <Clock className="size-3" /> Pendente
                </Badge>
            );
        case 'accepted':
            return (
                <Badge variant="default">
                    <CheckCircle2 className="size-3" /> Aceito
                </Badge>
            );
        case 'completed':
            return (
                <Badge
                    variant="default"
                    className="bg-green-600 hover:bg-green-700"
                >
                    <CheckCircle2 className="size-3" /> Concluído
                </Badge>
            );
        case 'declined':
            return (
                <Badge variant="destructive">
                    <XCircle className="size-3" /> Recusado
                </Badge>
            );
        case 'cancelled':
            return (
                <Badge variant="outline">
                    <Ban className="size-3" /> Cancelado
                </Badge>
            );
        default:
            return <Badge variant="secondary">{status}</Badge>;
    }
}

export default function Matches({
    matches,
    users,
    filters,
    states,
}: MatchIndexProps) {
    const [tab, setTab] = useState<'matches' | 'users'>('matches');
    const [userSearch, setUserSearch] = useState('');
    const [userStateFilter, setUserStateFilter] = useState(filters.state ?? '');
    const debounceRef = useRef<ReturnType<typeof setTimeout>>();

    const filteredUsers = users.data.filter((u) => {
        const matchSearch =
            !userSearch ||
            u.name.toLowerCase().includes(userSearch.toLowerCase());
        const matchState =
            !userStateFilter ||
            u.region ===
                states.find((s) => s.id.toString() === userStateFilter)?.uf;
        return matchSearch && matchState;
    });

    return (
        <>
            <Head title="Matches" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <Heading
                        variant="small"
                        title="Matches"
                        description="Conecte-se com outros profissionais"
                    />
                </div>

                <div className="flex gap-2 border-b pb-3">
                    <Button
                        variant={tab === 'matches' ? 'default' : 'ghost'}
                        size="sm"
                        onClick={() => setTab('matches')}
                        className="gap-2"
                    >
                        <ArrowRightLeft className="size-4" />
                        Meus matches
                        {matches.total > 0 && (
                            <Badge
                                variant="secondary"
                                className="ml-1 px-1.5 py-0 text-[10px]"
                            >
                                {matches.total}
                            </Badge>
                        )}
                    </Button>
                    <Button
                        variant={tab === 'users' ? 'default' : 'ghost'}
                        size="sm"
                        onClick={() => setTab('users')}
                        className="gap-2"
                    >
                        <Users className="size-4" />
                        Encontrar profissionais
                    </Button>
                </div>

                {tab === 'matches' && (
                    <>
                        <div className="flex gap-2">
                            {[
                                { value: '', label: 'Todos' },
                                { value: 'pending', label: 'Pendentes' },
                                { value: 'accepted', label: 'Aceitos' },
                                { value: 'completed', label: 'Concluídos' },
                            ].map((item) => (
                                <Button
                                    key={item.value}
                                    variant={
                                        filters.status === item.value ||
                                        (!filters.status && !item.value)
                                            ? 'default'
                                            : 'outline'
                                    }
                                    size="sm"
                                    onClick={() => {
                                        router.get(
                                            matchesIndex.url(),
                                            item.value
                                                ? { status: item.value }
                                                : {},
                                            { preserveState: true },
                                        );
                                    }}
                                >
                                    {item.label}
                                </Button>
                            ))}
                        </div>

                        {matches.data.length === 0 ? (
                            <EmptyState
                                icon={ArrowRightLeft}
                                title="Nenhum match encontrado"
                                description="Interaja com anúncios ou serviços para criar matches."
                            />
                        ) : (
                            <div className="grid gap-4 md:grid-cols-2">
                                {matches.data.map((match) => (
                                    <Card key={match.id}>
                                        <CardContent className="p-4 space-y-3">
                                            <div className="flex items-start justify-between">
                                                <h3 className="text-sm font-medium">
                                                    Match #{match.id}
                                                </h3>
                                                {statusBadge(match.status)}
                                            </div>

                                            <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                                <ArrowRightLeft className="size-4" />
                                                <span>{match.tradeType}</span>
                                                {match.price && (
                                                    <span className="font-medium text-foreground">
                                                        {match.price}
                                                    </span>
                                                )}
                                            </div>

                                            {match.item && (
                                                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                                    <Package className="size-4" />
                                                    <span>
                                                        {match.item.kind}:{' '}
                                                        {match.item.title}
                                                    </span>
                                                </div>
                                            )}

                                            <div className="flex items-center gap-2 text-sm">
                                                <span className="font-medium">
                                                    {match.counterpart.name}
                                                </span>
                                                <span className="text-muted-foreground">
                                                    - {match.counterpart.city},{' '}
                                                    {match.counterpart.region}
                                                </span>
                                            </div>

                                            {match.message && (
                                                <div className="flex items-start gap-2 rounded-md bg-muted p-3 text-sm text-muted-foreground">
                                                    <MessageSquare className="mt-0.5 size-4 shrink-0" />
                                                    <span>{match.message}</span>
                                                </div>
                                            )}

                                            {match.dispute && (
                                                <div className="flex items-center gap-2 rounded-md border border-destructive/50 bg-destructive/10 p-3 text-sm text-destructive">
                                                    <AlertTriangle className="size-4" />
                                                    <span>
                                                        Disputa aberta (#
                                                        {match.dispute.id})
                                                    </span>
                                                </div>
                                            )}

                                            <div className="text-xs text-muted-foreground">
                                                Criado {match.createdAt}
                                            </div>
                                        </CardContent>
                                    </Card>
                                ))}
                            </div>
                        )}
                    </>
                )}

                {tab === 'users' && (
                    <>
                        <div className="flex flex-col gap-3 rounded-xl border bg-card p-4 sm:flex-row sm:flex-wrap sm:items-end sm:gap-4">
                            <div className="flex flex-1 flex-col gap-1.5">
                                <Label className="text-xs text-muted-foreground">
                                    Buscar profissional
                                </Label>
                                <div className="relative">
                                    <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                    <Input
                                        placeholder="Buscar por nome..."
                                        value={userSearch}
                                        onChange={(e) =>
                                            setUserSearch(e.target.value)
                                        }
                                        className="h-9 pl-9"
                                    />
                                </div>
                            </div>
                            <div className="flex flex-1 flex-col gap-1.5 sm:max-w-64">
                                <Label className="text-xs text-muted-foreground">
                                    Estado
                                </Label>
                                <SearchSelect
                                    options={states.map((s) => ({
                                        value: s.id.toString(),
                                        label: `${s.uf} - ${s.name}`,
                                    }))}
                                    value={userStateFilter}
                                    onValueChange={(v) => setUserStateFilter(v)}
                                    placeholder="Todos os estados"
                                    clearable
                                />
                            </div>
                            {(userSearch || userStateFilter) && (
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    onClick={() => {
                                        setUserSearch('');
                                        setUserStateFilter('');
                                    }}
                                >
                                    <X className="size-3.5" />
                                    Limpar filtros
                                </Button>
                            )}
                        </div>

                        {filteredUsers.length === 0 ? (
                            <EmptyState
                                icon={Users}
                                title="Nenhum profissional encontrado"
                                description="Tente ajustar os filtros de busca."
                            />
                        ) : (
                            <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                {filteredUsers.map((user) => (
                                    <Card key={user.id}>
                                        <CardContent className="p-4">
                                            <div className="mb-3 flex items-start justify-between">
                                                <div>
                                                    <h3 className="text-sm font-semibold">
                                                        {user.name}
                                                    </h3>
                                                    <div className="mt-1 flex items-center gap-1 text-xs text-muted-foreground">
                                                        <MapPin className="size-3" />
                                                        <span>
                                                            {user.city},{' '}
                                                            {user.region}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            {user.services.length > 0 ? (
                                                <div className="space-y-2">
                                                    {user.services.map(
                                                        (service) => (
                                                            <div
                                                                key={service.id}
                                                                className="rounded-md bg-muted p-2.5"
                                                            >
                                                                <div className="flex items-start justify-between">
                                                                    <div className="flex-1">
                                                                        <p className="text-xs font-medium">
                                                                            {
                                                                                service.title
                                                                            }
                                                                        </p>
                                                                        {service.specialty && (
                                                                            <Badge
                                                                                variant="secondary"
                                                                                className="mt-1 text-[10px]"
                                                                            >
                                                                                {
                                                                                    service.specialty
                                                                                }
                                                                            </Badge>
                                                                        )}
                                                                    </div>
                                                                    {service.rate && (
                                                                        <span className="text-xs font-medium">
                                                                            {
                                                                                service.rate
                                                                            }
                                                                        </span>
                                                                    )}
                                                                </div>
                                                            </div>
                                                        ),
                                                    )}
                                                </div>
                                            ) : (
                                                <p className="text-xs text-muted-foreground">
                                                    Nenhum serviço cadastrado
                                                </p>
                                            )}

                                            {user.services.length > 0 && (
                                                <div className="mt-3 border-t pt-3">
                                                    <Button
                                                        variant="outline"
                                                        size="sm"
                                                        className="w-full"
                                                        asChild
                                                    >
                                                        <Link
                                                            href={serviceShow({
                                                                service:
                                                                    user
                                                                        .services[0]
                                                                        .id,
                                                            })}
                                                        >
                                                            <Camera className="size-3.5" />
                                                            Ver serviço
                                                        </Link>
                                                    </Button>
                                                </div>
                                            )}
                                        </CardContent>
                                    </Card>
                                ))}
                            </div>
                        )}
                    </>
                )}
            </div>
        </>
    );
}

Matches.layout = {
    breadcrumbs: [
        {
            title: 'Matches',
            href: matchesIndex(),
        },
    ],
};
