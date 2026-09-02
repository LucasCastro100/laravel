import { EmptyState } from '@/components/empty-state';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { SearchSelect } from '@/components/ui/search-select';
import {
    create as listingsCreate,
    index as listingsIndex,
    show as listingsShow,
} from '@/routes/listings';
import { Head, Link, router } from '@inertiajs/react';
import { MapPin, Package, Search } from 'lucide-react';
import { useCallback, useEffect, useRef, useState } from 'react';

type ListingItem = {
    id: number;
    title: string;
    category: string;
    condition: string | null;
    intent: string;
    type: string;
    price: string;
    region: string | null;
    city: string | null;
    status: string;
    ownerName: string;
    imageUrl: string | null;
    createdAt: string;
};

type PaginatedListings = {
    data: ListingItem[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
};

type Filters = {
    search?: string;
    category?: string;
    condition?: string;
    intent?: string;
    type?: string;
    region?: string;
    state_id?: string | number;
    municipality_id?: string | number;
    mine?: boolean;
};

type Option = { value: string; label: string };
type StateOption = { id: number; name: string; uf: string; region: string };
type MunicipalityOption = { id: number; name: string };

type Props = {
    listings: PaginatedListings;
    filters: Filters;
    categories: Option[];
    conditions: Option[];
    intents: Option[];
    types: Option[];
    regions: string[];
    states: StateOption[];
    municipalities: MunicipalityOption[];
};

export default function ListingsIndex({
    listings,
    filters,
    categories,
    conditions,
    intents,
    types,
    regions,
    states,
    municipalities: initialMunicipalities,
}: Props) {
    const [search, setSearch] = useState(filters.search ?? '');
    const [selectedRegion, setSelectedRegion] = useState(filters.region ?? '');
    const [municipalities, setMunicipalities] = useState<MunicipalityOption[]>(
        initialMunicipalities,
    );
    const [loadingMunicipalities, setLoadingMunicipalities] = useState(false);
    const debounceRef = useRef<ReturnType<typeof setTimeout>>();

    const activeFiltersCount = [
        filters.category,
        filters.condition,
        filters.intent,
        filters.type,
        filters.region,
        filters.state_id,
        filters.municipality_id,
        filters.mine ? 'mine' : null,
    ].filter(Boolean).length;

    const filteredStates = selectedRegion
        ? states.filter((s) => s.region === selectedRegion)
        : states;

    useEffect(() => {
        const stateId = String(filters.state_id ?? '');
        if (!stateId) {
            setMunicipalities([]);
            return;
        }
        setLoadingMunicipalities(true);
        fetch(`/municipalities?state_id=${stateId}`)
            .then((res) => res.json())
            .then((json: MunicipalityOption[]) => {
                setMunicipalities(json);
                setLoadingMunicipalities(false);
            })
            .catch(() => setLoadingMunicipalities(false));
    }, [filters.state_id]);

    const applyFilter = useCallback(
        (key: string, value: string | undefined) => {
            const params: Record<string, unknown> = {
                ...filters,
                [key]: value || undefined,
                page: undefined,
            };
            if (key === 'state_id') {
                params.municipality_id = undefined;
            }
            router.get(listingsIndex().url, params, {
                preserveState: true,
                replace: true,
            });
        },
        [filters],
    );

    const applyFilters = useCallback(
        (updates: Record<string, string | undefined>) => {
            const params: Record<string, unknown> = {
                ...filters,
                page: undefined,
            };
            for (const [key, value] of Object.entries(updates)) {
                params[key] = value || undefined;
            }
            router.get(listingsIndex().url, params, {
                preserveState: true,
                replace: true,
            });
        },
        [filters],
    );

    const handleSearch = useCallback(
        (value: string) => {
            setSearch(value);
            clearTimeout(debounceRef.current);
            debounceRef.current = setTimeout(() => {
                applyFilter('search', value || undefined);
            }, 400);
        },
        [applyFilter],
    );

    return (
        <>
            <Head title="Anúncios" />

            <div className="flex flex-col space-y-4">
                <div className="flex items-center justify-between">
                    <Heading
                        variant="small"
                        title="Vitrine de equipamentos"
                        description="Publicação de anúncios de equipamento para troca e/ou venda"
                    />
                    <Button asChild>
                        <Link href={listingsCreate().url}>Novo anúncio</Link>
                    </Button>
                </div>

                <div className="relative">
                    <Search className="absolute left-2.5 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        placeholder="Buscar anúncios..."
                        value={search}
                        onChange={(e) => handleSearch(e.target.value)}
                        className="pl-8"
                    />
                </div>

                <div className="flex flex-col gap-3 rounded-xl border bg-card p-4 sm:flex-row sm:flex-wrap sm:items-end sm:gap-4">
                    <div className="flex w-full flex-col gap-1.5 sm:w-40">
                        <Label className="text-xs text-muted-foreground">
                            Categoria
                        </Label>
                        <SearchSelect
                            options={categories.map((c) => ({
                                value: c.value,
                                label: c.label,
                            }))}
                            value={filters.category ?? ''}
                            onValueChange={(v) => applyFilter('category', v)}
                            placeholder="Todas"
                            clearable
                        />
                    </div>
                    <div className="flex w-full flex-col gap-1.5 sm:w-40">
                        <Label className="text-xs text-muted-foreground">
                            Condição
                        </Label>
                        <SearchSelect
                            options={conditions.map((c) => ({
                                value: c.value,
                                label: c.label,
                            }))}
                            value={filters.condition ?? ''}
                            onValueChange={(v) => applyFilter('condition', v)}
                            placeholder="Todas"
                            clearable
                        />
                    </div>
                    <div className="flex w-full flex-col gap-1.5 sm:w-40">
                        <Label className="text-xs text-muted-foreground">
                            Intenção
                        </Label>
                        <SearchSelect
                            options={intents.map((i) => ({
                                value: i.value,
                                label: i.label,
                            }))}
                            value={filters.intent ?? ''}
                            onValueChange={(v) => applyFilter('intent', v)}
                            placeholder="Todas"
                            clearable
                        />
                    </div>
                    <div className="flex w-full flex-col gap-1.5 sm:w-40">
                        <Label className="text-xs text-muted-foreground">
                            Negociação
                        </Label>
                        <SearchSelect
                            options={types.map((t) => ({
                                value: t.value,
                                label: t.label,
                            }))}
                            value={filters.type ?? ''}
                            onValueChange={(v) => applyFilter('type', v)}
                            placeholder="Todas"
                            clearable
                        />
                    </div>
                    <div className="flex w-full flex-col gap-1.5 sm:w-44">
                        <Label className="text-xs text-muted-foreground">
                            Região
                        </Label>
                        <SearchSelect
                            options={regions.map((r) => ({
                                value: r,
                                label: r,
                            }))}
                            value={selectedRegion}
                            onValueChange={(v) => {
                                setSelectedRegion(v);
                                applyFilters({
                                    region: v,
                                    state_id: '',
                                    municipality_id: '',
                                });
                            }}
                            placeholder="Todas"
                            clearable
                        />
                    </div>
                    <div className="flex w-full flex-col gap-1.5 sm:w-44">
                        <Label className="text-xs text-muted-foreground">
                            Estado
                        </Label>
                        <SearchSelect
                            options={filteredStates.map((s) => ({
                                value: s.id.toString(),
                                label: `${s.uf} - ${s.name}`,
                            }))}
                            value={String(filters.state_id ?? '')}
                            onValueChange={(v) => {
                                if (!v) {
                                    applyFilter('state_id', '');
                                    return;
                                }
                                const state = states.find(
                                    (s) => s.id.toString() === v,
                                );
                                if (state) {
                                    setSelectedRegion(state.region);
                                    applyFilters({
                                        state_id: v,
                                        region: state.region,
                                    });
                                } else {
                                    applyFilter('state_id', v);
                                }
                            }}
                            placeholder={
                                selectedRegion ? 'Estado' : 'Selecione a região'
                            }
                            disabled={!selectedRegion}
                            clearable
                        />
                    </div>
                    <div className="flex w-full flex-col gap-1.5 sm:w-44">
                        <Label className="text-xs text-muted-foreground">
                            Município
                        </Label>
                        <SearchSelect
                            options={municipalities.map((m) => ({
                                value: m.id.toString(),
                                label: m.name,
                            }))}
                            value={String(filters.municipality_id ?? '')}
                            onValueChange={(v) =>
                                applyFilter('municipality_id', v)
                            }
                            placeholder={
                                !filters.state_id
                                    ? 'Selecione o estado'
                                    : loadingMunicipalities
                                      ? 'Carregando...'
                                      : 'Município'
                            }
                            disabled={
                                !filters.state_id || loadingMunicipalities
                            }
                            clearable
                        />
                    </div>

                    <div className="flex w-full flex-col gap-1.5 sm:w-auto sm:flex-row sm:items-end">
                        <Button
                            variant={filters.mine ? 'default' : 'outline'}
                            onClick={() =>
                                applyFilter('mine', filters.mine ? '' : 'true')
                            }
                            className="sm:w-auto w-full"
                        >
                            Meus anúncios
                        </Button>
                    </div>

                    {activeFiltersCount > 0 && (
                        <Button
                            variant="ghost"
                            size="sm"
                            onClick={() =>
                                router.get(
                                    listingsIndex().url,
                                    {},
                                    { preserveState: true, replace: true },
                                )
                            }
                        >
                            Limpar filtros
                        </Button>
                    )}
                </div>

                {listings.data.length === 0 ? (
                    <EmptyState
                        icon={Package}
                        title="Nenhum anúncio encontrado"
                        description="Tente ajustar os filtros ou publique um novo anúncio."
                    />
                ) : (
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {listings.data.map((listing) => (
                            <Link
                                key={listing.id}
                                href={listingsShow({ listing: listing.id }).url}
                                className="group"
                            >
                                <Card className="transition-colors group-hover:border-primary/50">
                                    <CardContent className="space-y-3">
                                        {listing.imageUrl ? (
                                            <div className="aspect-video overflow-hidden rounded-md">
                                                <img
                                                    src={listing.imageUrl}
                                                    alt={listing.title}
                                                    className="size-full object-cover transition-transform group-hover:scale-105"
                                                />
                                            </div>
                                        ) : (
                                            <div className="flex aspect-video items-center justify-center rounded-md bg-muted">
                                                <Package className="size-8 text-muted-foreground/40" />
                                            </div>
                                        )}

                                        <div className="flex items-start justify-between gap-2">
                                            <h3 className="line-clamp-2 font-medium">
                                                {listing.title}
                                            </h3>
                                            <Badge
                                                variant="secondary"
                                                className="shrink-0"
                                            >
                                                {listing.intent}
                                            </Badge>
                                        </div>

                                        <div className="flex flex-wrap gap-1.5">
                                            <Badge variant="outline">
                                                {listing.category}
                                            </Badge>
                                            <Badge variant="outline">
                                                {listing.type}
                                            </Badge>
                                            {listing.condition && (
                                                <Badge variant="outline">
                                                    {listing.condition}
                                                </Badge>
                                            )}
                                        </div>

                                        <p className="text-sm font-semibold">
                                            {listing.price}
                                        </p>

                                        <div className="flex items-center justify-between text-xs text-muted-foreground">
                                            <span className="flex items-center gap-1">
                                                <MapPin className="size-3" />
                                                {listing.city && listing.region
                                                    ? `${listing.city}, ${listing.region}`
                                                    : (listing.region ??
                                                      listing.city ??
                                                      '—')}
                                            </span>
                                            <span>{listing.createdAt}</span>
                                        </div>

                                        <div className="border-t pt-2 text-xs text-muted-foreground">
                                            {listing.ownerName}
                                        </div>
                                    </CardContent>
                                </Card>
                            </Link>
                        ))}
                    </div>
                )}

                {listings.last_page > 1 && (
                    <div className="flex items-center justify-center gap-2">
                        {Array.from(
                            { length: listings.last_page },
                            (_, i) => i + 1,
                        ).map((page) => (
                            <Button
                                key={page}
                                variant={
                                    page === listings.current_page
                                        ? 'default'
                                        : 'outline'
                                }
                                size="sm"
                                onClick={() =>
                                    router.get(
                                        listingsIndex().url,
                                        { ...filters, page },
                                        { preserveState: true, replace: true },
                                    )
                                }
                            >
                                {page}
                            </Button>
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}

ListingsIndex.layout = {
    breadcrumbs: [{ title: 'Anúncios', href: listingsIndex().url }],
};
