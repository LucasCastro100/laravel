import { EmptyState } from '@/components/empty-state';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { SearchSelect } from '@/components/ui/search-select';
import {
    show as serviceShow,
    create as servicesCreate,
    index as servicesIndex,
} from '@/routes/services';
import { Head, Link, router } from '@inertiajs/react';
import { Camera, MapPin, Plus, Search } from 'lucide-react';
import { useCallback, useRef, useState } from 'react';

type ServiceItem = {
    id: number;
    title: string;
    specialty: string;
    rate: string;
    region: string;
    city: string;
    providerName: string;
    createdAt: string;
};

type PaginatedServices = {
    data: ServiceItem[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
};

type StateOption = { id: number; name: string; uf: string };

type Props = {
    services: PaginatedServices;
    filters: Record<string, string>;
    specialties: string[];
    states: StateOption[];
};

export default function ServicesIndex({
    services,
    filters,
    specialties,
    states,
}: Props) {
    const [search, setSearch] = useState(filters.search ?? '');
    const debounceRef = useRef<ReturnType<typeof setTimeout>>();

    const applyFilter = useCallback(
        (key: string, value: string | undefined) => {
            const params: Record<string, string | undefined> = {
                ...filters,
                [key]: value || undefined,
                page: undefined,
            };
            router.get(servicesIndex().url, params, {
                preserveState: true,
                replace: true,
            });
        },
        [filters],
    );

    const handleSearch = useCallback(
        (value: string) => {
    
            clearTimeout(debounceRef.current);
            debounceRef.current = setTimeout(() => {
                applyFilter('search', value || undefined);
            }, 400);
        },
        [applyFilter],
    );

    const activeFiltersCount = [filters.specialty, filters.state_id].filter(
        Boolean,
    ).length;

    return (
        <>
            <Head title="Serviços" />

            <div className="flex flex-col space-y-4">
                <div className="flex items-center justify-between">
                    <Heading
                        variant="small"
                        title="Serviços"
                        description="Encontre os melhores profissionais da plataforma"
                    />
                    <Button asChild>
                        <Link href={servicesCreate().url}>
                            <Plus className="size-4" />
                            Cadastrar serviço
                        </Link>
                    </Button>
                </div>

                <div className="space-y-3">
                    <div className="relative">
                        <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                        <Input
                            placeholder="Buscar por título do serviço..."
                            value={search}
                            onChange={(e) => handleSearch(e.target.value)}
                            className="h-10 pl-9"
                        />
                    </div>

                    <div className="flex flex-col gap-3 rounded-xl border bg-card p-4 sm:flex-row sm:flex-wrap sm:items-end sm:gap-4">
                        <div className="flex flex-1 flex-col gap-1.5 sm:max-w-64">
                            <Label className="text-xs text-muted-foreground">
                                Especialidade
                            </Label>
                            <SearchSelect
                                options={specialties.map((s) => ({
                                    value: s,
                                    label: s,
                                }))}
                                value={filters.specialty ?? ''}
                                onValueChange={(v) =>
                                    applyFilter('specialty', v)
                                }
                                placeholder="Todas"
                                clearable
                            />
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
                                value={filters.state_id ?? ''}
                                onValueChange={(v) =>
                                    applyFilter('state_id', v)
                                }
                                placeholder="Todos"
                                clearable
                            />
                        </div>
                        {activeFiltersCount > 0 && (
                            <Button
                                variant="ghost"
                                size="sm"
                                onClick={() =>
                                    router.get(
                                        servicesIndex().url,
                                        {},
                                        { preserveState: true, replace: true },
                                    )
                                }
                            >
                                Limpar filtros
                            </Button>
                        )}
                    </div>
                </div>

                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    {services.data.map((service) => (
                        <Card key={service.id} className="flex flex-col">
                            <CardContent className="flex flex-1 flex-col p-4">
                                <div className="mb-3 flex items-start justify-between">
                                    <div className="flex-1">
                                        <h3 className="line-clamp-1 text-sm font-semibold">
                                            {service.title}
                                        </h3>
                                        {service.specialty && (
                                            <Badge
                                                variant="secondary"
                                                className="mt-1 text-xs"
                                            >
                                                {service.specialty}
                                            </Badge>
                                        )}
                                    </div>
                                </div>

                                <div className="mb-3 space-y-1.5 text-sm">
                                    <div className="flex items-center justify-between">
                                        <span className="text-muted-foreground">
                                            Valor
                                        </span>
                                        <span className="font-medium">
                                            {service.rate}
                                        </span>
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <span className="text-muted-foreground">
                                            Profissional
                                        </span>
                                        <span className="font-medium">
                                            {service.providerName}
                                        </span>
                                    </div>
                                    <div className="flex items-center gap-1 text-muted-foreground">
                                        <MapPin className="size-3.5" />
                                        <span>
                                            {service.city}, {service.region}
                                        </span>
                                    </div>
                                </div>

                                <div className="mt-auto flex items-center justify-between border-t pt-3">
                                    <span className="text-xs text-muted-foreground">
                                        {new Date(
                                            service.createdAt,
                                        ).toLocaleDateString('pt-BR')}
                                    </span>
                                    <Button variant="ghost" size="sm" asChild>
                                        <Link
                                            href={serviceShow({
                                                service: service.id,
                                            })}
                                        >
                                            Ver detalhes
                                        </Link>
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {services.data.length === 0 && (
                    <EmptyState
                        icon={Camera}
                        title="Nenhum serviço encontrado"
                        description="Cadastre seu serviço ou ajuste os filtros de busca."
                        action={
                            <Button asChild size="sm">
                                <Link href={servicesCreate().url}>
                                    Cadastrar serviço
                                </Link>
                            </Button>
                        }
                    />
                )}

                {services.last_page > 1 && (
                    <div className="flex items-center justify-center gap-2">
                        {Array.from(
                            { length: services.last_page },
                            (_, i) => i + 1,
                        ).map((page) => (
                            <Button
                                key={page}
                                variant={
                                    page === services.current_page
                                        ? 'default'
                                        : 'outline'
                                }
                                size="sm"
                                asChild
                            >
                                <Link href={servicesIndex({ query: { page } })}>
                                    {page}
                                </Link>
                            </Button>
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}

ServicesIndex.layout = {
    breadcrumbs: [
        {
            title: 'Serviços',
            href: servicesIndex(),
        },
    ],
};
