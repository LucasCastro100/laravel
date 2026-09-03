import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { store as diagnosticoStore } from '@/routes/diagnostico';
import { Head, router } from '@inertiajs/react';
import { BarChart3, CheckCircle2, RotateCcw } from 'lucide-react';
import { useMemo, useState } from 'react';

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

interface DiagnosticoIndexProps {
    areas: Area[];
}

type Resposta = {
    letra: string;
    pontos: number;
};

type Respostas = Record<string, Resposta>;

export default function DiagnosticoIndex({ areas }: DiagnosticoIndexProps) {
    const [respostas, setRespostas] = useState<Respostas>({});

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

    const handleSelect = (perguntaId: string, alternativa: Alternativa) => {
        setRespostas((prev) => ({
            ...prev,
            [perguntaId]: {
                letra: alternativa.letra,
                pontos: alternativa.pontos,
            },
        }));
    };

    const handleSubmit = () => {
        if (!todasRespondidas) return;
        router.post(diagnosticoStore().url, { respostas });
    };

    const handleReset = () => {
        setRespostas({});
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
                                Responda as 7 áreas para mapear o ponto de
                                partida do seu negócio.
                            </p>
                        </div>
                    </div>
                    <Button variant="ghost" onClick={handleReset}>
                        <RotateCcw className="size-4" />
                        Limpar
                    </Button>
                </header>

                {areas.map((area) => (
                    <Card key={area.area_key}>
                        <CardHeader>
                            <CardTitle>{area.area}</CardTitle>
                            <CardDescription>
                                Marque a alternativa que mais se aproxima da
                                sua realidade atual.
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-8">
                            {area.perguntas.map((pergunta, perguntaIndex) => (
                                <div key={pergunta.id} className="space-y-3">
                                    <p className="font-medium">
                                        {perguntaIndex + 1}. {pergunta.text}
                                    </p>
                                    <fieldset className="space-y-2">
                                        <legend className="sr-only">
                                            {pergunta.text}
                                        </legend>
                                        {pergunta.alternativas.map(
                                            (alternativa) => {
                                                const isSelected =
                                                    respostas[pergunta.id]
                                                        ?.letra ===
                                                    alternativa.letra;
                                                return (
                                                    <label
                                                        key={alternativa.letra}
                                                        className={`flex cursor-pointer items-start gap-3 rounded-lg border bg-background px-3 py-2 text-sm transition-colors ${
                                                            isSelected
                                                                ? 'border-primary bg-primary/5'
                                                                : 'hover:bg-accent'
                                                        }`}
                                                    >
                                                        <input
                                                            type="radio"
                                                            name={pergunta.id}
                                                            className="mt-0.5"
                                                            checked={isSelected}
                                                            onChange={() =>
                                                                handleSelect(
                                                                    pergunta.id,
                                                                    alternativa,
                                                                )
                                                            }
                                                        />
                                                        <span className="text-muted-foreground">
                                                            {alternativa.letra}){' '}
                                                        </span>
                                                        <span>
                                                            {alternativa.text}
                                                        </span>
                                                    </label>
                                                );
                                            },
                                        )}
                                    </fieldset>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                ))}

                <Button
                    className="w-full"
                    size="lg"
                    onClick={handleSubmit}
                    disabled={!todasRespondidas}
                >
                    <CheckCircle2 className="size-4" />
                    Ver meu resultado
                </Button>

                {!todasRespondidas && (
                    <p className="text-center text-sm text-muted-foreground">
                        Respondidas {respondidas} de {totalPerguntas} perguntas.
                    </p>
                )}
            </div>
        </>
    );
}