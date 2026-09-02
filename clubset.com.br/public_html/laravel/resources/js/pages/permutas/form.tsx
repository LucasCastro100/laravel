import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { MoneyInput } from '@/components/ui/money-input';
import { SearchSelect } from '@/components/ui/search-select';
import { Stepper } from '@/components/ui/stepper';
import { cn } from '@/lib/utils';
import {
    create as permutaCreate,
    edit as permutaEdit,
    store as permutaStore,
    update as permutaUpdate,
    index as permutasIndex,
} from '@/routes/permutas';
import { Head, useForm } from '@inertiajs/react';
import {
    ArrowLeft,
    ArrowRight,
    Check,
    CheckCircle2,
    FileText,
    Repeat,
    User,
    UserRound,
} from 'lucide-react';
import { useEffect, useState } from 'react';

type UsuarioOption = { id: number; name: string };

type PermutaForm = {
    contato_id: number | '';
    contato_nome: string;
    contato_sobrenome: string;
    contato_email: string;
    titulo: string;
    descricao: string;
    valor: string;
    data: string;
    status: string;
};

type Props = {
    permuta: {
        id: number;
        contato: { id: number | null; nome: string; ehUsuario: boolean };
        titulo: string | null;
        descricao: string | null;
        valor: number;
        data: string | null;
        status: string;
    } | null;
    usuarios: UsuarioOption[];
};

const STEPS = ['Contato', 'Detalhes', 'Revisão'] as const;
const STEP_ICONS = [User, FileText, CheckCircle2] as const;

export default function PermutaForm({ permuta, usuarios }: Props) {
    const isEditing = Boolean(permuta);
    const [step, setStep] = useState(0);
    const [contatoTipo, setContatoTipo] = useState<'usuario' | 'avulso'>(
        permuta?.contato.ehUsuario ? 'usuario' : 'avulso',
    );

    const editingValorCents = permuta
        ? String(Math.round(permuta.valor * 100))
        : '';

    const { data, setData, post, put, errors, processing, reset } =
        useForm<PermutaForm>({
            contato_id: permuta?.contato.id ?? '',
            contato_nome: permuta?.contato.ehUsuario
                ? ''
                : (permuta?.contato.nome ?? ''),
            contato_sobrenome: '',
            contato_email: '',
            titulo: permuta?.titulo ?? '',
            descricao: permuta?.descricao ?? '',
            valor: editingValorCents,
            data: permuta?.data ?? '',
            status: permuta?.status ?? 'concluida',
        });

    useEffect(() => {
        if (!isEditing) {
            reset();
        }
    }, [isEditing]);

    const next = () => setStep((s) => Math.min(s + 1, STEPS.length - 1));
    const prev = () => setStep((s) => Math.max(s - 1, 0));

    const submit = (e: React.FormEvent) => {
        e.preventDefault();

        if (contatoTipo === 'usuario') {
            data.contato_nome = '';
            data.contato_sobrenome = '';
            data.contato_email = '';
        } else {
            data.contato_id = '';
            data.contato_nome =
                `${data.contato_nome.trim()} ${data.contato_sobrenome.trim()}`.trim();
        }
        data.data = data.data || '';

        if (isEditing) {
            put(permutaUpdate({ permuta: permuta!.id }).url, {
                onSuccess: () => setStep(0),
            });
        } else {
            post(permutaStore().url, {
                onSuccess: () => setStep(0),
            });
        }
    };

    return (
        <>
            <Head title={isEditing ? 'Editar permuta' : 'Nova permuta'} />

            <div className="flex flex-col space-y-4">
                <div className="flex items-center gap-3">
                    <Button variant="ghost" size="sm" asChild>
                        <a href={permutasIndex().url}>
                            <ArrowLeft className="size-4" />
                        </a>
                    </Button>
                    <Heading
                        variant="small"
                        title={isEditing ? 'Editar permuta' : 'Nova permuta'}
                        description={
                            isEditing
                                ? 'Atualize as informações da permuta'
                                : 'Lance uma nova permuta em alguns passos'
                        }
                    />
                </div>

                <Stepper
                    steps={STEPS.map((label, i) => ({
                        label,
                        icon: STEP_ICONS[i],
                    }))}
                    current={step}
                    onStepChange={setStep}
                />

                <form onSubmit={submit} className="space-y-4">
                    {step === 0 && (
                        <Card>
                            <CardHeader className="py-3">
                                <CardTitle className="text-base">
                                    Quem está do outro lado?
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="grid gap-3 sm:grid-cols-2">
                                    <button
                                        type="button"
                                        onClick={() => {
                                            setContatoTipo('usuario');
                                            setData('contato_nome', '');
                                        }}
                                        className={cn(
                                            'group relative flex items-start gap-3 rounded-xl border-2 p-4 text-left transition-all',
                                            contatoTipo === 'usuario'
                                                ? 'border-primary bg-primary/5 shadow-sm ring-1 ring-primary'
                                                : 'border-muted hover:border-primary/50 hover:bg-accent',
                                        )}
                                    >
                                        <div
                                            className={cn(
                                                'mt-0.5 flex size-10 shrink-0 items-center justify-center rounded-full transition-colors',
                                                contatoTipo === 'usuario'
                                                    ? 'bg-primary text-primary-foreground'
                                                    : 'bg-muted text-muted-foreground group-hover:bg-primary/10 group-hover:text-primary',
                                            )}
                                        >
                                            <User className="size-5" />
                                        </div>
                                        <div>
                                            <p className="font-medium">
                                                Usuário cadastrado
                                            </p>
                                            <p className="text-sm text-muted-foreground">
                                                Vincula um usuário já existente
                                                na plataforma.
                                            </p>
                                        </div>
                                        {contatoTipo === 'usuario' && (
                                            <span className="absolute top-3 right-3 flex size-5 items-center justify-center rounded-full bg-primary text-primary-foreground">
                                                <Check
                                                    className="size-3"
                                                    strokeWidth={3}
                                                />
                                            </span>
                                        )}
                                    </button>

                                    <button
                                        type="button"
                                        onClick={() => {
                                            setContatoTipo('avulso');
                                            setData('contato_id', '');
                                        }}
                                        className={cn(
                                            'group relative flex items-start gap-3 rounded-xl border-2 p-4 text-left transition-all',
                                            contatoTipo === 'avulso'
                                                ? 'border-primary bg-primary/5 shadow-sm ring-1 ring-primary'
                                                : 'border-muted hover:border-primary/50 hover:bg-accent',
                                        )}
                                    >
                                        <div
                                            className={cn(
                                                'mt-0.5 flex size-10 shrink-0 items-center justify-center rounded-full transition-colors',
                                                contatoTipo === 'avulso'
                                                    ? 'bg-primary text-primary-foreground'
                                                    : 'bg-muted text-muted-foreground group-hover:bg-primary/10 group-hover:text-primary',
                                            )}
                                        >
                                            <UserRound className="size-5" />
                                        </div>
                                        <div>
                                            <p className="font-medium">
                                                Pessoa avulsa
                                            </p>
                                            <p className="text-sm text-muted-foreground">
                                                Cadastra uma nova pessoa por
                                                nome e e-mail (senha padrão).
                                            </p>
                                        </div>
                                        {contatoTipo === 'avulso' && (
                                            <span className="absolute top-3 right-3 flex size-5 items-center justify-center rounded-full bg-primary text-primary-foreground">
                                                <Check
                                                    className="size-3"
                                                    strokeWidth={3}
                                                />
                                            </span>
                                        )}
                                    </button>
                                </div>

                                <div
                                    key={contatoTipo}
                                    className="animate-in fade-in slide-in-from-top-2 duration-300"
                                >
                                    {contatoTipo === 'usuario' ? (
                                        <div className="grid gap-2">
                                            <Label>Usuário vinculado</Label>
                                            <SearchSelect
                                                options={usuarios.map((u) => ({
                                                    value: String(u.id),
                                                    label: u.name,
                                                }))}
                                                value={
                                                    data.contato_id === ''
                                                        ? ''
                                                        : String(
                                                              data.contato_id,
                                                          )
                                                }
                                                onValueChange={(v) =>
                                                    setData(
                                                        'contato_id',
                                                        v === ''
                                                            ? ''
                                                            : Number(v),
                                                    )
                                                }
                                                placeholder="Busque e selecione um usuário"
                                                title="Usuário"
                                                clearable
                                            />
                                            <InputError
                                                message={errors.contato_id}
                                            />
                                        </div>
                                    ) : (
                                        <div className="grid gap-3">
                                            <div className="grid gap-3 sm:grid-cols-2">
                                                <div className="grid gap-2">
                                                    <Label htmlFor="contato_nome">
                                                        Nome
                                                    </Label>
                                                    <Input
                                                        id="contato_nome"
                                                        value={
                                                            data.contato_nome
                                                        }
                                                        onChange={(e) =>
                                                            setData(
                                                                'contato_nome',
                                                                e.target.value,
                                                            )
                                                        }
                                                        placeholder="Ex: João"
                                                    />
                                                    <InputError
                                                        message={
                                                            errors.contato_nome
                                                        }
                                                    />
                                                </div>
                                                <div className="grid gap-2">
                                                    <Label htmlFor="contato_sobrenome">
                                                        Sobrenome
                                                    </Label>
                                                    <Input
                                                        id="contato_sobrenome"
                                                        value={
                                                            data.contato_sobrenome
                                                        }
                                                        onChange={(e) =>
                                                            setData(
                                                                'contato_sobrenome',
                                                                e.target.value,
                                                            )
                                                        }
                                                        placeholder="Ex: Silva"
                                                    />
                                                </div>
                                            </div>
                                            <div className="grid gap-2">
                                                <Label htmlFor="contato_email">
                                                    Email
                                                </Label>
                                                <Input
                                                    id="contato_email"
                                                    type="email"
                                                    value={data.contato_email}
                                                    onChange={(e) =>
                                                        setData(
                                                            'contato_email',
                                                            e.target.value,
                                                        )
                                                    }
                                                    placeholder="Ex: joao@email.com"
                                                />
                                                <InputError
                                                    message={
                                                        errors.contato_email
                                                    }
                                                />
                                                <p className="text-xs text-muted-foreground">
                                                    Essa pessoa será cadastrada
                                                    e receberá a senha padrão
                                                    para acessar o painel.
                                                </p>
                                            </div>
                                        </div>
                                    )}
                                </div>

                                <div className="flex items-center justify-end">
                                    <Button type="button" onClick={next}>
                                        Próximo
                                        <ArrowRight className="size-4" />
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    )}

                    {step === 1 && (
                        <Card>
                            <CardHeader className="py-3">
                                <CardTitle className="text-base">
                                    Detalhes da permuta
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                <div className="grid gap-3 sm:grid-cols-2">
                                    <div className="grid gap-2">
                                        <Label htmlFor="titulo">Título</Label>
                                        <Input
                                            id="titulo"
                                            value={data.titulo}
                                            onChange={(e) =>
                                                setData(
                                                    'titulo',
                                                    e.target.value,
                                                )
                                            }
                                            placeholder="Ex: Filmagem de evento"
                                        />
                                        <InputError message={errors.titulo} />
                                    </div>
                                    <div className="grid gap-2">
                                        <Label htmlFor="valor">
                                            Valor (R$)
                                        </Label>
                                        <MoneyInput
                                            id="valor"
                                            value={data.valor}
                                            onChange={(v) =>
                                                setData('valor', v)
                                            }
                                        />
                                        <InputError message={errors.valor} />
                                    </div>
                                </div>

                                <div className="grid gap-3 sm:grid-cols-2">
                                    <div className="grid gap-2">
                                        <Label htmlFor="data">Data</Label>
                                        <Input
                                            id="data"
                                            type="date"
                                            value={data.data}
                                            onChange={(e) =>
                                                setData('data', e.target.value)
                                            }
                                        />
                                        <InputError message={errors.data} />
                                    </div>
                                    <div className="grid gap-2">
                                        <Label>Status</Label>
                                        <SearchSelect
                                            options={[
                                                {
                                                    value: 'pendente',
                                                    label: 'Pendente',
                                                },
                                                {
                                                    value: 'concluida',
                                                    label: 'Concluída',
                                                },
                                                {
                                                    value: 'cancelada',
                                                    label: 'Cancelada',
                                                },
                                            ]}
                                            value={data.status}
                                            onValueChange={(v) =>
                                                setData('status', v)
                                            }
                                            placeholder="Status"
                                            title="Status"
                                        />
                                        <InputError message={errors.status} />
                                    </div>
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="descricao">Descrição</Label>
                                    <textarea
                                        id="descricao"
                                        rows={3}
                                        value={data.descricao}
                                        onChange={(e) =>
                                            setData('descricao', e.target.value)
                                        }
                                        placeholder="Descreva a permuta..."
                                        className="flex w-full min-w-0 rounded-md border bg-transparent px-3 py-2 text-base shadow-xs outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] md:text-sm"
                                    />
                                    <InputError message={errors.descricao} />
                                </div>

                                <div className="flex items-center justify-between">
                                    <Button
                                        type="button"
                                        variant="outline"
                                        onClick={prev}
                                    >
                                        <ArrowLeft className="size-4" />
                                        Voltar
                                    </Button>
                                    <Button type="button" onClick={next}>
                                        Próximo
                                        <ArrowRight className="size-4" />
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    )}

                    {step === 2 && (
                        <Card>
                            <CardHeader className="py-3">
                                <CardTitle className="text-base">
                                    Revise antes de lançar
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                <dl className="space-y-2 rounded-md bg-muted p-4 text-sm">
                                    <div className="flex justify-between">
                                        <dt className="text-muted-foreground">
                                            Lado vinculado
                                        </dt>
                                        <dd className="font-medium">
                                            {contatoTipo === 'usuario'
                                                ? data.contato_id
                                                    ? (usuarios.find(
                                                          (u) =>
                                                              u.id ===
                                                              data.contato_id,
                                                      )?.name ??
                                                      `${data.contato_id}`)
                                                    : '—'
                                                : `${`${data.contato_nome.trim()} ${data.contato_sobrenome.trim()}`.trim() || '—'}${data.contato_email ? ` (${data.contato_email})` : ''}`}
                                        </dd>
                                    </div>
                                    <div className="flex justify-between">
                                        <dt className="text-muted-foreground">
                                            Título
                                        </dt>
                                        <dd className="font-medium">
                                            {data.titulo || '—'}
                                        </dd>
                                    </div>
                                    <div className="flex justify-between">
                                        <dt className="text-muted-foreground">
                                            Valor
                                        </dt>
                                        <dd className="font-semibold">
                                            {data.valor
                                                ? `R$ ${(Number(data.valor) / 100).toFixed(2).replace('.', ',')}`
                                                : '—'}
                                        </dd>
                                    </div>
                                    <div className="flex justify-between">
                                        <dt className="text-muted-foreground">
                                            Data
                                        </dt>
                                        <dd className="font-medium">
                                            {data.data || '—'}
                                        </dd>
                                    </div>
                                    <div className="flex justify-between">
                                        <dt className="text-muted-foreground">
                                            Status
                                        </dt>
                                        <dd className="font-medium capitalize">
                                            {data.status || '—'}
                                        </dd>
                                    </div>
                                </dl>

                                <p className="rounded-md bg-green-600/10 p-3 text-sm text-green-700">
                                    <Repeat className="mr-1 inline size-4" />
                                    Ao lançar esta permuta, você a registrará
                                    como ganho (entrada).
                                </p>

                                <div className="flex items-center justify-between">
                                    <Button
                                        type="button"
                                        variant="outline"
                                        onClick={prev}
                                    >
                                        <ArrowLeft className="size-4" />
                                        Voltar
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        {processing
                                            ? 'Salvando...'
                                            : isEditing
                                              ? 'Salvar alterações'
                                              : 'Lançar permuta'}
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    )}
                </form>
            </div>
        </>
    );
}

PermutaForm.layout = (props: { permuta?: Props['permuta'] }) => {
    const permuta = props.permuta ?? null;

    return {
        breadcrumbs: [
            {
                title: 'Permutas',
                href: permutasIndex(),
            },
            {
                title: permuta ? 'Editar permuta' : 'Nova permuta',
                href: permuta
                    ? permutaEdit({ permuta: permuta.id })
                    : permutaCreate(),
            },
        ],
    };
};
