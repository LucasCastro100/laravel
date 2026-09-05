import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { diagnosticos as diagnosticosIndex } from '@/routes/admin';
import {
    release as diagnosticoRelease,
    show as diagnosticoShow,
} from '@/routes/admin/diagnosticos';
import { Form, Head, Link } from '@inertiajs/react';
import {
    AlertTriangle,
    ArrowLeft,
    AtSign,
    ClipboardList,
    Lock,
    MapPin,
    MessageCircle,
    Phone,
    Trophy,
    User,
    Wallet,
} from 'lucide-react';

interface Localizacao {
    id: number;
    name: string;
    uf: string;
}

interface Contato {
    uuid: string;
    nome: string;
    instagram: string;
    celular: string;
    estado: Localizacao | null;
    municipio: Localizacao | null;
    participaGrupo: boolean;
    grupoQual: string | null;
    renda: string;
    resultadoLiberado: boolean;
    criadoEm: string | null;
}

interface AreaResultado {
    area: string;
    area_key: string;
    pontos: number;
    normalizado: number;
    faixa: 'critico' | 'construcao' | 'solido';
    faixa_label: string;
    texto?: string;
}

interface Resultado {
    geral: number;
    faixa_geral: string;
    faixa_geral_label: string;
    areas: AreaResultado[];
    criticos: AreaResultado[];
}

interface DiagnosticoShowProps {
    diagnostico: Contato;
    resultado: Resultado;
}

function faixaClasse(faixa: 'critico' | 'construcao' | 'solido'): string {
    if (faixa === 'critico') {
        return 'bg-red-500 text-white';
    }
    if (faixa === 'construcao') {
        return 'bg-yellow-500 text-black';
    }
    return 'bg-green-500 text-white';
}

function barraClasse(faixa: 'critico' | 'construcao' | 'solido'): string {
    if (faixa === 'critico') {
        return 'bg-red-500';
    }
    if (faixa === 'construcao') {
        return 'bg-yellow-500';
    }
    return 'bg-green-500';
}

const faixaExplicacao: Record<string, string> = {
    critico:
        'Seu negócio está funcionando quase sem estrutura, cada projeto começa do zero, os preços não têm base fixa e os processos vivem só na sua cabeça. Isso trava o crescimento hoje e é o que mais coloca em risco a sustentabilidade do negócio a médio prazo.',
    construcao:
        'Você já tem algumas estruturas funcionando, mas ainda existem muitas decisões no improviso. Há processos, preços e estratégias sendo construídos, porém sem consistência suficiente para gerar previsibilidade. O próximo passo é transformar o que hoje depende de você em processos claros, organizados e repetíveis.',
    solido: 'Seu negócio já possui uma estrutura clara para vender, atender e entregar. Preços, processos, propostas e contratos estão organizados, permitindo mais previsibilidade e segurança para crescer. O foco agora deixa de ser apenas organizar a operação e passa a ser otimizar, aumentar a eficiência e criar novas oportunidades de crescimento.',
};

export default function DiagnosticoShow({
    diagnostico,
    resultado,
}: DiagnosticoShowProps) {
    const localizacao = [diagnostico.municipio?.name, diagnostico.estado?.uf]
        .filter(Boolean)
        .join(', ');

    return (
        <>
            <Head title={`Diagnóstico - ${diagnostico.nome}`} />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <div>
                        <Button
                            variant="ghost"
                            size="sm"
                            asChild
                            className="mb-2"
                        >
                            <Link href={diagnosticosIndex()}>
                                <ArrowLeft className="size-4" />
                                Voltar
                            </Link>
                        </Button>
                        <h1 className="text-lg font-semibold">
                            Diagnóstico de {diagnostico.nome}
                        </h1>
                    </div>
                    <div className="flex items-center gap-3">
                        {diagnostico.resultadoLiberado ? (
                            <Badge className="bg-green-600 hover:bg-green-700">
                                Resultado liberado
                            </Badge>
                        ) : (
                            <Form
                                {...diagnosticoRelease.form({
                                    uuid: diagnostico.uuid,
                                })}
                            >
                                <Button type="submit">
                                    <Lock className="size-4" />
                                    Liberar resultado
                                </Button>
                            </Form>
                        )}
                        <div className="flex size-11 items-center justify-center rounded-xl bg-primary text-primary-foreground">
                            <ClipboardList className="size-6" />
                        </div>
                    </div>
                </div>

                <div className="grid gap-4 md:grid-cols-2">
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2 text-base">
                                <User className="size-4" />
                                Dados do contato
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-2 text-sm">
                            <div className="flex items-center justify-between">
                                <span className="text-muted-foreground">
                                    Nome
                                </span>
                                <span className="font-medium">
                                    {diagnostico.nome}
                                </span>
                            </div>
                            <div className="flex items-center justify-between">
                                <span className="text-muted-foreground">
                                    Instagram
                                </span>
                                <span className="flex items-center gap-1 font-medium">
                                    <AtSign className="size-4" />
                                    {diagnostico.instagram}
                                </span>
                            </div>
                            <div className="flex items-center justify-between">
                                <span className="text-muted-foreground">
                                    Celular
                                </span>
                                <span className="flex items-center gap-1 font-medium">
                                    <Phone className="size-4" />
                                    {diagnostico.celular}
                                </span>
                            </div>
                            <div className="flex items-center justify-between">
                                <span className="text-muted-foreground">
                                    Localização
                                </span>
                                <span className="flex items-center gap-1 font-medium">
                                    <MapPin className="size-4" />
                                    {localizacao || '-'}
                                </span>
                            </div>
                            <div className="flex items-center justify-between">
                                <span className="text-muted-foreground">
                                    Grupo WhatsApp
                                </span>
                                <span className="flex items-center gap-1 font-medium">
                                    <MessageCircle className="size-4" />
                                    {diagnostico.participaGrupo
                                        ? diagnostico.grupoQual
                                        : 'Não participa'}
                                </span>
                            </div>
                            <div className="flex items-center justify-between">
                                <span className="text-muted-foreground">
                                    Renda
                                </span>
                                <span className="flex items-center gap-1 font-medium">
                                    <Wallet className="size-4" />
                                    {diagnostico.renda}
                                </span>
                            </div>
                            {diagnostico.criadoEm && (
                                <div className="pt-2 text-xs text-muted-foreground">
                                    Enviado{' '}
                                    {new Date(
                                        diagnostico.criadoEm,
                                    ).toLocaleString('pt-BR')}
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2 text-base">
                                <Trophy className="size-4" />
                                Pontuação geral
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="flex items-end justify-between gap-4">
                            <div>
                                <p className="text-5xl font-bold">
                                    {resultado?.geral ?? '-'}
                                </p>
                                <p className="text-sm text-muted-foreground">
                                    de 100
                                </p>
                            </div>
                            {resultado && (
                                <Badge
                                    className={faixaClasse(
                                        resultado.faixa_geral as
                                            | 'critico'
                                            | 'construcao'
                                            | 'solido',
                                    )}
                                >
                                    {resultado.faixa_geral_label}
                                </Badge>
                            )}
                        </CardContent>
                        {resultado && (
                            <CardContent>
                                <p className="text-sm leading-relaxed text-muted-foreground">
                                    {faixaExplicacao[resultado.faixa_geral]}
                                </p>
                            </CardContent>
                        )}
                    </Card>
                </div>

                {!resultado || resultado.areas.length === 0 ? (
                    <Card>
                        <CardContent className="flex flex-col items-center gap-4 py-10 text-center">
                            <AlertTriangle className="size-10 text-muted-foreground" />
                            <p className="text-muted-foreground">
                                Nenhum resultado encontrado.
                            </p>
                        </CardContent>
                    </Card>
                ) : (
                    <>
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2 text-base">
                                    <AlertTriangle className="size-5 text-red-500" />
                                    Pontos mais críticos
                                </CardTitle>
                                <CardDescription>
                                    As 2 áreas com menor pontuação para
                                    priorizar.
                                </CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-2">
                                {resultado.criticos.map((r) => (
                                    <div
                                        key={r.area_key}
                                        className="flex items-center justify-between rounded-md bg-muted px-3 py-2 text-sm"
                                    >
                                        <span className="font-medium">
                                            {r.area}
                                        </span>
                                        <span className="font-semibold">
                                            {r.normalizado}
                                        </span>
                                    </div>
                                ))}
                            </CardContent>
                        </Card>

                        <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            {resultado.areas.map((r) => (
                                <Card key={r.area_key}>
                                    <CardHeader>
                                        <CardTitle className="text-base">
                                            {r.area}
                                        </CardTitle>
                                        <div className="flex items-center gap-2">
                                            <Badge
                                                className={faixaClasse(r.faixa)}
                                            >
                                                {r.faixa_label}
                                            </Badge>
                                            <span className="text-sm font-semibold">
                                                {r.normalizado}
                                            </span>
                                        </div>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="h-2 w-full overflow-hidden rounded-full bg-muted">
                                            <div
                                                className={`${barraClasse(r.faixa)} h-full`}
                                                style={{
                                                    width: `${r.normalizado}%`,
                                                }}
                                            />
                                        </div>
                                        {r.texto && (
                                            <p className="mt-3 text-sm leading-relaxed text-muted-foreground">
                                                <span className="font-bold">
                                                    O que isso significa:{' '}
                                                </span>
                                                {r.texto}
                                            </p>
                                        )}
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    </>
                )}
            </div>
        </>
    );
}

DiagnosticoShow.layout = {
    breadcrumbs: [
        {
            title: 'Diagnósticos',
            href: diagnosticosIndex(),
        },
        {
            title: 'Detalhe',
            href: diagnosticoShow({ uuid: 'uuid' }),
        },
    ],
};
