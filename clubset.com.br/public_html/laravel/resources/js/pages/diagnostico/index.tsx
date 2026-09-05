import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { SearchSelect } from '@/components/ui/search-select';
import { Stepper } from '@/components/ui/stepper';
import { store as diagnosticoStore } from '@/routes/diagnostico';
import { Form, Head } from '@inertiajs/react';
import {
    BarChart3,
    CheckCircle2,
    ChevronLeft,
    ChevronRight,
    MapPin,
    RotateCcw,
    User2,
    Wallet,
} from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';

type Alternativa = {
    letra: string;
    text: string;
    pontos: number;
};

type Pergunta = {
    id: string;
    text: string;
    alternativas: Alternativa[];
};

type Area = {
    area: string;
    area_key: string;
    perguntas: Pergunta[];
};

type StateOption = { id: number; name: string; uf: string; region: string };
type MunicipalityOption = { id: number; name: string };

interface DiagnosticoIndexProps {
    areas: Area[];
    listaRendas: string[];
    states: StateOption[];
    regions: string[];
}

type Resposta = {
    letra: string;
    pontos: number;
};

type Respostas = Record<string, Resposta>;

function formatPhone(value: string): string {
    const digits = value.replace(/\D/g, '').slice(0, 11);

    if (digits.length <= 2) {
        return digits;
    }

    if (digits.length <= 7) {
        return `(${digits.slice(0, 2)}) ${digits.slice(2)}`;
    }

    if (digits.length <= 10) {
        return `(${digits.slice(0, 2)}) ${digits.slice(2, 6)}-${digits.slice(6)}`;
    }

    return `(${digits.slice(0, 2)}) ${digits.slice(2, 7)}-${digits.slice(7)}`;
}

export default function DiagnosticoIndex({
    areas,
    listaRendas,
    states,
    regions,
}: DiagnosticoIndexProps) {
    const [step, setStep] = useState(0);
    const [respostas, setRespostas] = useState<Respostas>({});

    const [renda, setRenda] = useState('');

    const [selectedRegion, setSelectedRegion] = useState('');
    const [stateId, setStateId] = useState('');
    const [municipalityId, setMunicipalityId] = useState('');
    const [municipalities, setMunicipalities] = useState<
        MunicipalityOption[]
    >([]);
    const [loadingMunicipalities, setLoadingMunicipalities] = useState(false);
    const [participaGrupo, setParticipaGrupo] = useState(false);
    const [celular, setCelular] = useState('');

    const totalPerguntas = useMemo(
        () => areas.reduce((acc, area) => acc + area.perguntas.length, 0),
        [areas],
    );

    const respondidas = useMemo(
        () =>
            areas.reduce(
                (acc, area) =>
                    acc +
                    area.perguntas.filter(
                        (p) => respostas[p.id] !== undefined,
                    ).length,
                0,
            ),
        [areas, respostas],
    );

    const todasRespondidas = respondidas === totalPerguntas;

    const steps = [
        { label: 'Renda', icon: Wallet },
        { label: 'Seus dados', icon: User2 },
        { label: 'Perguntas', icon: BarChart3 },
    ];

    const filteredStates = selectedRegion
        ? states.filter((s) => s.region === selectedRegion)
        : states;

    const stateOptions = filteredStates.map((s) => ({
        value: s.id.toString(),
        label: `${s.uf} - ${s.name}`,
    }));

    const municipalityOptions = municipalities.map((m) => ({
        value: m.id.toString(),
        label: m.name,
    }));

    useEffect(() => {
        if (!stateId) {
            setMunicipalities([]);
            setMunicipalityId('');
            return;
        }
        setLoadingMunicipalities(true);
        setMunicipalityId('');
        fetch(`/diagnostico/municipalities?state_id=${stateId}`)
            .then((res) => res.json())
            .then((json: MunicipalityOption[]) => {
                setMunicipalities(json);
                setLoadingMunicipalities(false);
            })
            .catch(() => setLoadingMunicipalities(false));
    }, [stateId]);

    const handleSelect = (perguntaId: string, alternativa: Alternativa) => {
        setRespostas((prev) => ({
            ...prev,
            [perguntaId]: {
                letra: alternativa.letra,
                pontos: alternativa.pontos,
            },
        }));
    };

    const handleReset = () => {
        setRespostas({});
        setSelectedRegion('');
        setStateId('');
        setMunicipalities([]);
        setMunicipalityId('');
        setParticipaGrupo(false);
        setCelular('');
        setRenda('');
        setStep(0);
    };

    return (
        <>
            <Head title="Diagnóstico" />

            <div className="mx-auto w-full max-w-6xl space-y-8 p-6">
                <header className="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                    <div className="flex items-center gap-3">
                        <div className="flex size-11 items-center justify-center rounded-xl bg-primary text-primary-foreground">
                            <BarChart3 className="size-6" />
                        </div>
                        <div>
                            <h1 className="text-2xl font-bold">Diagnóstico</h1>
                            <p className="text-sm text-muted-foreground">
                                Mapeie o ponto de partida do seu negócio.
                            </p>
                        </div>
                    </div>
                    <Button variant="ghost" onClick={handleReset}>
                        <RotateCcw className="size-4" />
                        Limpar
                    </Button>
                </header>

                <Stepper steps={steps} current={step} onStepChange={setStep} />

                <Form
                    method="post"
                    action={diagnosticoStore().url}
                    className="space-y-8"
                >
                    {({ errors, processing }) => (
                        <>
                            <Card
                                className={step === 0 ? '' : 'hidden'}
                            >
                                <CardHeader className="-mt-6 border-b bg-muted/40 px-6 pt-4 pb-4">
                                    <CardTitle className="flex items-center gap-2">
                                        <Wallet className="size-5 text-primary" />
                                        Renda
                                    </CardTitle>
                                    <CardDescription>
                                        Qual a sua faixa de renda mensal?
                                    </CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-2 pt-6">
                                    <input
                                        type="hidden"
                                        name="renda"
                                        value={renda}
                                    />
                                    {listaRendas.map((opcao) => (
                                        <label
                                            key={opcao}
                                            className={`flex cursor-pointer items-center gap-3 rounded-lg border bg-background px-3 py-2 text-sm transition-colors ${
                                                renda === opcao
                                                    ? 'border-primary bg-primary/5'
                                                    : 'hover:bg-accent'
                                            }`}
                                        >
                                            <input
                                                type="radio"
                                                name="renda-radio"
                                                value={opcao}
                                                checked={renda === opcao}
                                                onChange={() => setRenda(opcao)}
                                            />
                                            <span>{opcao}</span>
                                        </label>
                                    ))}
                                </CardContent>
                            </Card>

                            <Card
                                className={step === 1 ? '' : 'hidden'}
                            >
                                <CardHeader className="-mt-6 border-b bg-muted/40 px-6 pt-4 pb-4">
                                    <CardTitle className="flex items-center gap-2">
                                        <MapPin className="size-5 text-primary" />
                                        Seus dados
                                    </CardTitle>
                                    <CardDescription>
                                        Conte um pouco sobre você antes de
                                        começar as perguntas.
                                    </CardDescription>
                                </CardHeader>
                                    <CardContent className="space-y-4 pt-6">
                                        <div className="grid gap-4 sm:grid-cols-2">
                                            <div className="grid gap-2">
                                                <Label htmlFor="nome">
                                                    Nome
                                                </Label>
                                                <Input
                                                    id="nome"
                                                    name="nome"
                                                    placeholder="Seu nome"
                                                />
                                            </div>
                                            <div className="grid gap-2">
                                                <Label htmlFor="instagram">
                                                    Instagram
                                                </Label>
                                                <Input
                                                    id="instagram"
                                                    name="instagram"
                                                    placeholder="@seuinstagram"
                                                />
                                            </div>
                                            <div className="grid gap-2">
                                                <Label htmlFor="celular">
                                                    Celular
                                                </Label>
                                                <input
                                                    type="hidden"
                                                    name="celular"
                                                    value={celular}
                                                />
                                                <Input
                                                    id="celular"
                                                    value={celular}
                                                    onChange={(e) =>
                                                        setCelular(
                                                            formatPhone(
                                                                e.target.value,
                                                            ),
                                                        )
                                                    }
                                                    placeholder="(11) 99999-9999"
                                                    inputMode="tel"
                                                />
                                            </div>
                                        </div>

                                        <div className="grid gap-4 sm:grid-cols-3">
                                            <div className="grid gap-2">
                                                <Label>Região</Label>
                                                <SearchSelect
                                                    options={regions.map(
                                                        (r) => ({
                                                            value: r,
                                                            label: r,
                                                        }),
                                                    )}
                                                    value={selectedRegion}
                                                    onValueChange={(v) => {
                                                        setSelectedRegion(v);
                                                        setStateId('');
                                                        setMunicipalities([]);
                                                        setMunicipalityId('');
                                                    }}
                                                    placeholder="Selecione a região"
                                                    title="Região"
                                                    clearable
                                                />
                                            </div>
                                            <div className="grid gap-2">
                                                <Label>Estado</Label>
                                                <SearchSelect
                                                    options={stateOptions}
                                                    name="state_id"
                                                    value={stateId}
                                                    onValueChange={setStateId}
                                                    placeholder={
                                                        selectedRegion
                                                            ? 'Selecione o estado'
                                                            : 'Selecione a região primeiro'
                                                    }
                                                    disabled={!selectedRegion}
                                                    title="Estado"
                                                />
                                            </div>
                                            <div className="grid gap-2">
                                                <Label>Município</Label>
                                                <SearchSelect
                                                    options={municipalityOptions}
                                                    name="municipality_id"
                                                    value={municipalityId}
                                                    onValueChange={
                                                        setMunicipalityId
                                                    }
                                                    placeholder={
                                                        !stateId
                                                            ? 'Selecione o estado primeiro'
                                                            : loadingMunicipalities
                                                              ? 'Carregando...'
                                                              : 'Selecione o município'
                                                    }
                                                    disabled={
                                                        !stateId ||
                                                        loadingMunicipalities
                                                    }
                                                    title="Município"
                                                    clearable
                                                />
                                            </div>
                                        </div>

                                        <div className="space-y-3 rounded-lg border p-4">
                                            <Label asChild>
                                                <span>
                                                    Participa dos grupos
                                                    WhatsApp @robsonokia?
                                                </span>
                                            </Label>
                                            <div className="flex gap-6">
                                                <label className="flex cursor-pointer items-center gap-2 text-sm">
                                                    <input
                                                        type="radio"
                                                        name="participa_grupo_whatsapp"
                                                        value="1"
                                                        onChange={() =>
                                                            setParticipaGrupo(
                                                                true,
                                                            )
                                                        }
                                                    />
                                                    Sim
                                                </label>
                                                <label className="flex cursor-pointer items-center gap-2 text-sm">
                                                    <input
                                                        type="radio"
                                                        name="participa_grupo_whatsapp"
                                                        value="0"
                                                        onChange={() =>
                                                            setParticipaGrupo(
                                                                false,
                                                            )
                                                        }
                                                    />
                                                    Não
                                                </label>
                                            </div>
                                            {participaGrupo && (
                                                <div className="grid gap-2 pt-2">
                                                    <Label htmlFor="grupo_whatsapp_qual">
                                                        Qual grupo?
                                                    </Label>
                                                    <Input
                                                        id="grupo_whatsapp_qual"
                                                        name="grupo_whatsapp_qual"
                                                        placeholder="Nome do grupo"
                                                    />
                                                </div>
                                            )}
                                        </div>
                                    </CardContent>
                            </Card>

                            <div
                                className={`space-y-8 ${
                                    step === 2 ? '' : 'hidden'
                                }`}
                            >
                                {areas.map((area) => (
                                        <Card key={area.area_key}>
                                            <CardHeader>
                                                <CardTitle>
                                                    {area.area}
                                                </CardTitle>
                                                <CardDescription>
                                                    Marque a alternativa que
                                                    mais se aproxima da sua
                                                    realidade atual.
                                                </CardDescription>
                                            </CardHeader>
                                            <CardContent className="space-y-8">
                                                {area.perguntas.map(
                                                    (
                                                        pergunta,
                                                        perguntaIndex,
                                                    ) => (
                                                        <div
                                                            key={pergunta.id}
                                                            className="space-y-3"
                                                        >
                                                            <p className="font-medium">
                                                                {perguntaIndex +
                                                                    1}
                                                                .{' '}
                                                                {pergunta.text}
                                                            </p>
                                                            <fieldset className="space-y-2">
                                                                <legend className="sr-only">
                                                                    {
                                                                        pergunta.text
                                                                    }
                                                                </legend>
                                                                {pergunta.alternativas.map(
                                                                    (
                                                                        alternativa,
                                                                    ) => {
                                                                        const isSelected =
                                                                            respostas[
                                                                                pergunta
                                                                                    .id
                                                                            ]
                                                                                ?.letra ===
                                                                            alternativa.letra;
                                                                        return (
                                                                            <label
                                                                                key={
                                                                                    alternativa.letra
                                                                                }
                                                                                className={`flex cursor-pointer items-start gap-3 rounded-lg border bg-background px-3 py-2 text-sm transition-colors ${
                                                                                    isSelected
                                                                                        ? 'border-primary bg-primary/5'
                                                                                        : 'hover:bg-accent'
                                                                                }`}
                                                                            >
                                                                                <input
                                                                                    type="radio"
                                                                                    name={`respostas[${
                                                                                        pergunta
                                                                                            .id
                                                                                    }][letra]`}
                                                                                    value={
                                                                                        alternativa.letra
                                                                                    }
                                                                                    className="mt-0.5"
                                                                                    checked={
                                                                                        isSelected
                                                                                    }
                                                                                    onChange={() =>
                                                                                        handleSelect(
                                                                                            pergunta.id,
                                                                                            alternativa,
                                                                                        )
                                                                                    }
                                                                                />
                                                                                <span className="text-muted-foreground">
                                                                                    {
                                                                                        alternativa.letra
                                                                                    }
                                                                                    ){' '}
                                                                                </span>
                                                                                <span>
                                                                                    {
                                                                                        alternativa.text
                                                                                    }
                                                                                </span>
                                                                            </label>
                                                                        );
                                                                    },
                                                                )}
                                                            </fieldset>
                                                        </div>
                                                    ),
                                                )}
                                            </CardContent>
                                        </Card>
                                    ))}
                            </div>

                            <div className="flex items-center justify-between gap-3">
                                <Button
                                    variant="outline"
                                    type="button"
                                    onClick={() =>
                                        setStep((s) => Math.max(0, s - 1))
                                    }
                                    disabled={step === 0 || processing}
                                >
                                    <ChevronLeft className="size-4" />
                                    Voltar
                                </Button>

                                {step < steps.length - 1 ? (
                                    <Button
                                        type="button"
                                        disabled={step === 0 && !renda}
                                        onClick={() =>
                                            setStep((s) =>
                                                Math.min(s + 1, steps.length - 1),
                                            )
                                        }
                                    >
                                        Avançar
                                        <ChevronRight className="size-4" />
                                    </Button>
                                ) : (
                                    <Button
                                        type="submit"
                                        disabled={
                                            !todasRespondidas || processing
                                        }
                                    >
                                        {processing ? (
                                            <span className="size-4 animate-spin rounded-full border-2 border-current border-t-transparent" />
                                        ) : (
                                            <CheckCircle2 className="size-4" />
                                        )}
                                        Ver meu resultado
                                    </Button>
                                )}
                            </div>

                            {step === 2 && !todasRespondidas && (
                                <p className="text-center text-sm text-muted-foreground">
                                    Respondidas {respondidas} de{' '}
                                    {totalPerguntas} perguntas.
                                </p>
                            )}
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}
