import { EmptyState } from '@/components/empty-state';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import {
    create as permutaCreate,
    destroy as permutaDestroy,
    edit as permutaEdit,
    index as permutasIndex,
} from '@/routes/permutas';
import { Head, Link, router } from '@inertiajs/react';
import {
    ArrowDownRight,
    ArrowUpRight,
    CalendarRange,
    Copy,
    Filter,
    Pencil,
    Plus,
    Repeat,
    Trash2,
    UserRound,
} from 'lucide-react';
import { useMemo, useState } from 'react';
import { toast } from 'sonner';

interface PermutaItem {
    id: number;
    uuid: string;
    titulo: string | null;
    descricao: string | null;
    valor: number;
    formattedValor: string;
    data: string | null;
    status: string;
    statusLabel: string;
    isCreator: boolean;
    contato: {
        id: number | null;
        nome: string;
        ehUsuario: boolean;
    };
    shareUrl: string;
}

interface Summary {
    ganhos: number;
    despesas: number;
    total: number;
}

interface PermutasIndexProps {
    permutas: PermutaItem[];
    summary: Summary;
}

function formatBRL(value: number): string {
    return `R$ ${value.toFixed(2).replace('.', ',')}`;
}

function statusBadge(status: string, label: string) {
    if (status === 'concluida') {
        return (
            <Badge
                variant="default"
                className="bg-green-600 hover:bg-green-700"
            >
                {label}
            </Badge>
        );
    }
    if (status === 'cancelada') {
        return <Badge variant="outline">{label}</Badge>;
    }
    return <Badge variant="secondary">{label}</Badge>;
}

export default function PermutasIndex({
    permutas,
    summary,
}: PermutasIndexProps) {
    const positive = summary.total >= 0;
    const totalColor = positive ? 'text-green-600' : 'text-red-600';

    const [origem, setOrigem] = useState<'todas' | 'criadas' | 'vinculadas'>(
        'todas',
    );
    const [dataInicio, setDataInicio] = useState('');
    const [dataFim, setDataFim] = useState('');

    const toIso = (value: string): string => {
        const parts = value.split('/');
        if (parts.length !== 3) {
            return '';
        }
        const [d, m, y] = parts;
        return `${y}-${m}-${d}`;
    };

    const filtered = useMemo(() => {
        return permutas.filter((permuta) => {
            const origemOk =
                origem === 'todas' ||
                (origem === 'criadas' && permuta.isCreator) ||
                (origem === 'vinculadas' && !permuta.isCreator);

            let dataOk = true;
            if (permuta.data) {
                const iso = toIso(permuta.data);
                if (dataInicio && iso < dataInicio) {
                    dataOk = false;
                }
                if (dataFim && iso > dataFim) {
                    dataOk = false;
                }
            } else if (dataInicio || dataFim) {
                dataOk = false;
            }

            return origemOk && dataOk;
        });
    }, [permutas, origem, dataInicio, dataFim]);

    const copyLink = (url: string) => {
        navigator.clipboard.writeText(url);
        toast.success('Link de compartilhamento copiado!');
    };

    const confirmDelete = (permuta: PermutaItem) => {
        if (
            window.confirm(
                `Excluir a permuta "${permuta.titulo ?? `#${permuta.id}`}"?`,
            )
        ) {
            router.delete(permutaDestroy({ permuta: permuta.id }), {});
        }
    };

    return (
        <>
            <Head title="Permutas" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <Heading
                        variant="small"
                        title="Permutas"
                        description="Lance suas permutas e acompanhe o fluxo de caixa"
                    />
                    <Button asChild>
                        <Link href={permutaCreate()}>
                            <Plus className="size-4" />
                            Nova permuta
                        </Link>
                    </Button>
                </div>

                <div className="grid gap-4 sm:grid-cols-3">
                    <Card>
                        <CardContent className="space-y-1 p-5">
                            <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                <ArrowUpRight className="size-4 text-green-600" />
                                Ganhos (entrada)
                            </div>
                            <p className="text-2xl font-semibold text-green-600">
                                {formatBRL(summary.ganhos)}
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="space-y-1 p-5">
                            <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                <ArrowDownRight className="size-4 text-red-600" />
                                Despesas (saída)
                            </div>
                            <p className="text-2xl font-semibold text-red-600">
                                {formatBRL(summary.despesas)}
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="space-y-1 p-5">
                            <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                <Repeat className="size-4" />
                                Total
                            </div>
                            <p
                                className={`text-2xl font-semibold ${totalColor}`}
                            >
                                {formatBRL(summary.total)}
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <div className="flex flex-col gap-3 rounded-xl border bg-card p-4 sm:flex-row sm:flex-wrap sm:items-end sm:gap-4">
                    <div className="flex flex-col gap-1.5">
                        <Label className="text-xs text-muted-foreground">
                            <UserRound className="mr-1 inline size-3.5" />
                            Origem
                        </Label>
                        <div className="flex gap-1 rounded-md border p-1">
                            {(
                                [
                                    ['todas', 'Todas'],
                                    ['criadas', 'Eu criei'],
                                    ['vinculadas', 'Me vincularam'],
                                ] as const
                            ).map(([value, label]) => (
                                <button
                                    key={value}
                                    type="button"
                                    onClick={() => setOrigem(value)}
                                    className={cn(
                                        'rounded px-3 py-1.5 text-xs font-medium transition-colors',
                                        origem === value
                                            ? 'bg-primary text-primary-foreground'
                                            : 'text-muted-foreground hover:bg-muted',
                                    )}
                                >
                                    {label}
                                </button>
                            ))}
                        </div>
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <Label
                            htmlFor="permuta-data-inicio"
                            className="text-xs text-muted-foreground"
                        >
                            De
                        </Label>
                        <Input
                            id="permuta-data-inicio"
                            type="date"
                            value={dataInicio}
                            onChange={(e) => setDataInicio(e.target.value)}
                            className="w-full sm:w-40"
                        />
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <Label
                            htmlFor="permuta-data-fim"
                            className="text-xs text-muted-foreground"
                        >
                            Até
                        </Label>
                        <Input
                            id="permuta-data-fim"
                            type="date"
                            value={dataFim}
                            onChange={(e) => setDataFim(e.target.value)}
                            className="w-full sm:w-40"
                        />
                    </div>

                    {(origem !== 'todas' || dataInicio || dataFim) && (
                        <Button
                            variant="ghost"
                            size="sm"
                            onClick={() => {
                                setOrigem('todas');
                                setDataInicio('');
                                setDataFim('');
                            }}
                        >
                            <Filter className="size-3.5" />
                            Limpar filtros
                        </Button>
                    )}
                </div>

                {permutas.length === 0 ? (
                    <EmptyState
                        icon={Repeat}
                        title="Nenhuma permuta lançada"
                        description="Crie sua primeira permuta para começar a controlar o fluxo de caixa."
                    />
                ) : filtered.length === 0 ? (
                    <EmptyState
                        icon={CalendarRange}
                        title="Nenhum resultado"
                        description="Nenhuma permuta corresponde aos filtros aplicados."
                    />
                ) : (
                    <div className="overflow-hidden rounded-xl border bg-card shadow-sm">
                        <div className="hidden grid-cols-12 gap-4 border-b bg-muted/50 px-5 py-3 text-xs font-medium uppercase tracking-wide text-muted-foreground md:grid">
                            <div className="col-span-4">Permuta</div>
                            <div className="col-span-2">Status</div>
                            <div className="col-span-2">Vínculo</div>
                            <div className="col-span-1">Valor</div>
                            <div className="col-span-2">Data</div>
                            <div className="col-span-1 text-right">Ações</div>
                        </div>
                        <ul className="divide-y divide-border">
                            {filtered.map((permuta) => (
                                <li
                                    key={permuta.id}
                                    className="grid grid-cols-1 gap-3 px-5 py-4 transition-colors hover:bg-muted/30 md:grid-cols-12 md:items-center md:gap-4"
                                >
                                    <div className="col-span-4 flex flex-col gap-1">
                                        <div className="flex items-center gap-2">
                                            <h3 className="text-sm font-medium">
                                                {permuta.titulo ??
                                                    `Permuta #${permuta.id}`}
                                            </h3>
                                            {permuta.isCreator ? (
                                                <Badge
                                                    variant="secondary"
                                                    className="bg-green-600/10 text-green-700"
                                                >
                                                    Você criou
                                                </Badge>
                                            ) : (
                                                <Badge variant="secondary">
                                                    Vinculado
                                                </Badge>
                                            )}
                                        </div>
                                        {permuta.descricao && (
                                            <p className="line-clamp-1 text-xs text-muted-foreground">
                                                {permuta.descricao}
                                            </p>
                                        )}
                                    </div>

                                    <div className="col-span-2">
                                        {statusBadge(
                                            permuta.status,
                                            permuta.statusLabel,
                                        )}
                                    </div>

                                    <div className="col-span-2 flex items-center gap-2 text-sm text-muted-foreground">
                                        <Repeat className="size-4 text-[#3fd6c9]" />
                                        <span>{permuta.contato.nome}</span>
                                    </div>

                                    <div className="col-span-1 text-base font-semibold">
                                        {permuta.formattedValor}
                                    </div>

                                    <div className="col-span-2 text-xs text-muted-foreground">
                                        {permuta.data ?? 'Sem data'}
                                    </div>

                                    <div className="col-span-1 flex justify-end gap-1">
                                        {!permuta.contato.ehUsuario && (
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                onClick={() =>
                                                    copyLink(permuta.shareUrl)
                                                }
                                            >
                                                <Copy className="size-3.5" />
                                                Compartilhar
                                            </Button>
                                        )}
                                        {permuta.isCreator && (
                                            <>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    asChild
                                                >
                                                    <Link
                                                        href={permutaEdit({
                                                            permuta: permuta.id,
                                                        })}
                                                    >
                                                        <Pencil className="size-3.5" />
                                                    </Link>
                                                </Button>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    className="text-destructive"
                                                    onClick={() =>
                                                        confirmDelete(permuta)
                                                    }
                                                >
                                                    <Trash2 className="size-3.5" />
                                                </Button>
                                            </>
                                        )}
                                    </div>
                                </li>
                            ))}
                        </ul>
                    </div>
                )}
            </div>
        </>
    );
}

PermutasIndex.layout = {
    breadcrumbs: [
        {
            title: 'Permutas',
            href: permutasIndex(),
        },
    ],
};
