import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Head } from '@inertiajs/react';
import jsPDF from 'jspdf';
import {
    AlertTriangle,
    ArrowRight,
    CheckCircle2,
    Copy,
    Download,
    Lock,
    MessageCircle,
    QrCode,
    TrendingDown,
    Trophy,
} from 'lucide-react';
import { useState } from 'react';
import { toast } from 'sonner';

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

type Resposta = {
    letra: string;
    pontos: number;
};

type AreaResultado = {
    area: string;
    area_key: string;
    pontos: number;
    normalizado: number;
    faixa: 'critico' | 'construcao' | 'solido';
    faixa_label: string;
    texto?: string;
};

type Resultado = {
    geral: number;
    faixa_geral: string;
    faixa_geral_label: string;
    areas: AreaResultado[];
    criticos: AreaResultado[];
};

interface DiagnosticoResultadoProps {
    areas: Area[];
    respostas: Record<string, Resposta>;
    resultado: Resultado;
    liberado: boolean;
    pix: {
        label: string;
        amount: string;
        code: string;
    };
}

function PixDialog({
    pix,
    open,
    onOpenChange,
}: {
    pix: DiagnosticoResultadoProps['pix'];
    open: boolean;
    onOpenChange: (open: boolean) => void;
}) {
    const [copied, setCopied] = useState(false);

    const copyCode = () => {
        navigator.clipboard.writeText(pix.code);
        setCopied(true);
        toast.success('Código PIX copiado!');
        setTimeout(() => setCopied(false), 2000);
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle className="flex items-center gap-2">
                        <QrCode className="size-5 text-primary" />
                        {pix.label}
                    </DialogTitle>
                    <DialogDescription>
                        Pague {pix.amount} via PIX para liberar o diagnóstico
                        detalhado. Assim que identificarmos o pagamento, a
                        versão completa será liberada.
                    </DialogDescription>
                </DialogHeader>
                <div className="space-y-2">
                    <p className="text-xs font-medium uppercase tracking-wide text-muted-foreground">
                        PIX Copia e Cola
                    </p>
                    <div className="max-h-40 overflow-y-auto rounded-md bg-muted p-3 font-mono text-xs break-all">
                        {pix.code}
                    </div>
                </div>
                <DialogFooter>
                    <Button onClick={copyCode}>
                        <Copy className="size-4" />
                        {copied ? 'Copiado!' : 'Copiar código PIX'}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}

const corHexFaixa: Record<string, [number, number, number]> = {
    critico: [220, 38, 38],
    construcao: [234, 179, 8],
    solido: [34, 197, 94],
};

const faixaExplicacao: Record<string, string> = {
    critico:
        'Seu negócio está funcionando quase sem estrutura, cada projeto começa do zero, os preços não têm base fixa e os processos vivem só na sua cabeça. Isso trava o crescimento hoje e é o que mais coloca em risco a sustentabilidade do negócio a médio prazo.',
    construcao:
        'Você já tem algumas estruturas funcionando, mas ainda existem muitas decisões no improviso. Há processos, preços e estratégias sendo construídos, porém sem consistência suficiente para gerar previsibilidade. O próximo passo é transformar o que hoje depende de você em processos claros, organizados e repetíveis.',
    solido: 'Seu negócio já possui uma estrutura clara para vender, atender e entregar. Preços, processos, propostas e contratos estão organizados, permitindo mais previsibilidade e segurança para crescer. O foco agora deixa de ser apenas organizar a operação e passa a ser otimizar, aumentar a eficiência e criar novas oportunidades de crescimento.',
};

function gerarPdf(
    areas: Area[],
    respostas: Record<string, Resposta>,
    resultado: Resultado,
    modo: 'resumo' | 'completo',
) {
    const doc = new jsPDF({ unit: 'pt', format: 'a4' });
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const margin = 40;
    let y = 0;

    const checkPage = (needed = 60) => {
        if (y + needed > pageHeight - margin) {
            doc.addPage();
            y = margin;
        }
    };

    const cor = (faixa: string): [number, number, number] =>
        faixa === 'critico'
            ? corHexFaixa.critico
            : faixa === 'construcao'
              ? corHexFaixa.construcao
              : corHexFaixa.solido;
    // Cabeçalho do relatório
    doc.setFillColor(11, 48, 92);
    doc.rect(0, 0, pageWidth, 120, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(22);
    doc.text('Diagnóstico do Negócio', margin, 55);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(12);
    doc.text(`Data: ${new Date().toLocaleDateString('pt-BR')}`, margin, 85);
    y = 150;

    // Pontuação geral
    doc.setTextColor(20, 20, 20);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(16);
    doc.text('Pontuação geral', margin, y);
    y += 32;

    const [gr, gg, gb] = cor(resultado.faixa_geral);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(48);
    doc.setTextColor(gr, gg, gb);
    doc.text(String(resultado.geral), margin, y + 12);
    doc.setTextColor(120, 120, 120);
    doc.setFontSize(12);
    doc.text('de 100', margin + 60, y + 12);
    doc.setFont('helvetica', 'normal');
    y += 28;

    doc.setFillColor(gr, gg, gb);
    doc.roundedRect(margin, y, 90, 24, 6, 6, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(11);
    doc.text(resultado.faixa_geral_label, margin + 45, y + 16, {
        align: 'center',
    });
    y += 40;

    doc.setTextColor(60, 60, 60);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(11);
    const explicacaoGeral = doc.splitTextToSize(
        faixaExplicacao[resultado.faixa_geral] ?? '',
        pageWidth - margin * 2,
    );
    doc.text(explicacaoGeral, margin, y);
    y += explicacaoGeral.length * 15 + 20;

    // Áreas mais críticas
    checkPage(140);
    doc.setTextColor(220, 38, 38);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(14);
    doc.text('Pontos mais críticos', margin, y);
    y += 26;

    resultado.criticos.forEach((area) => {
        checkPage(26);
        doc.setFillColor(245, 245, 245);
        doc.roundedRect(margin, y, pageWidth - margin * 2, 24, 4, 4, 'F');
        doc.setTextColor(40, 40, 40);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(11);
        doc.text(area.area, margin + 10, y + 16);
        doc.setFont('helvetica', 'bold');
        doc.text(String(area.normalizado), pageWidth - margin - 10, y + 16, {
            align: 'right',
        });
        y += 34;
    });

    // Score por área
    checkPage(160);
    y += 24;
    doc.setTextColor(20, 20, 20);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(16);
    doc.text('Pontuação por área', margin, y);
    y += 32;

    resultado.areas.forEach((area) => {
        checkPage(140);
        const [ar, ag, ab] = cor(area.faixa);
        doc.setTextColor(20, 20, 20);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(12);
        doc.text(area.area, margin, y);
        doc.setTextColor(ar, ag, ab);
        doc.setFontSize(12);
        doc.text(String(area.normalizado), pageWidth - margin, y, {
            align: 'right',
        });

        y += 16;
        doc.setFillColor(230, 230, 230);
        doc.roundedRect(margin, y, pageWidth - margin * 2, 10, 5, 5, 'F');
        doc.setFillColor(ar, ag, ab);
        const barW = (pageWidth - margin * 2) * (area.normalizado / 100);
        if (barW > 0) {
            doc.roundedRect(margin, y, barW, 10, 5, 5, 'F');
        }
        y += 22;

        if (area.texto) {
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(90, 90, 90);
            const explicacaoArea = doc.splitTextToSize(
                area.texto,
                pageWidth - margin * 2,
            );
            doc.text(explicacaoArea, margin, y);
            y += explicacaoArea.length * 13 + 24;
        } else {
            y += 30;
        }
    });

    // Respostas selecionadas (apenas no modo completo)
    if (modo === 'completo') {
        doc.addPage();
        y = margin;
        doc.setFillColor(11, 48, 92);
        doc.rect(0, 0, pageWidth, 80, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(18);
        doc.text('Suas respostas', margin, 45);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(11);
        doc.text(
            'Cada alternativa marcada corresponde à resposta escolhida.',
            margin,
            65,
        );
        y = 110;

        const alturaPergunta = (pergunta: Pergunta, index: number): number => {
            const textoPergunta = `${index + 1}. ${pergunta.text}`;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(11);
            const perguntaLines = doc.splitTextToSize(
                textoPergunta,
                pageWidth - margin * 2,
            );
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(11);

            let altura = perguntaLines.length * 15 + 12;
            pergunta.alternativas.forEach((alt) => {
                const altLines = doc.splitTextToSize(
                    `${alt.letra}) ${alt.text}`,
                    pageWidth - margin * 2 - 30,
                );
                altura += altLines.length * 14 + 6;
            });
            return altura + 16 + 20;
        };

        areas.forEach((area) => {
            // altura total da área = cabeçalho + todas as perguntas
            const alturaArea =
                24 +
                area.perguntas.reduce(
                    (total, pergunta, index) =>
                        total + alturaPergunta(pergunta, index + 1),
                    0,
                );

            // quebra página antes se a área inteira não couber junta
            checkPage(alturaArea);

            doc.setTextColor(11, 48, 92);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(14);
            doc.text(area.area, margin, y);
            y += 24;

            area.perguntas.forEach((pergunta, index) => {
                const resposta = respostas[pergunta.id];
                const textoPergunta = `${index + 1}. ${pergunta.text}`;

                doc.setFont('helvetica', 'bold');
                doc.setFontSize(11);
                const perguntaLines = doc.splitTextToSize(
                    textoPergunta,
                    pageWidth - margin * 2,
                );
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(11);

                doc.setTextColor(40, 40, 40);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(11);
                doc.text(perguntaLines, margin, y);
                y += perguntaLines.length * 15 + 10;

                pergunta.alternativas.forEach((alt) => {
                    const isSelected = resposta?.letra === alt.letra;

                    if (isSelected) {
                        doc.setFillColor(11, 48, 92);
                        doc.circle(margin + 5, y - 4, 6, 'F');
                        doc.setTextColor(11, 48, 92);
                        doc.setFont('helvetica', 'bold');
                    } else {
                        doc.setDrawColor(180, 180, 180);
                        doc.circle(margin + 5, y - 4, 6, 'S');
                        doc.setTextColor(120, 120, 120);
                        doc.setFont('helvetica', 'normal');
                    }

                    const altLines = doc.splitTextToSize(
                        `${alt.letra}) ${alt.text}`,
                        pageWidth - margin * 2 - 30,
                    );
                    doc.text(altLines, margin + 25, y);
                    y += altLines.length * 14 + 6;
                });

                y += 20;
            });
        });
    }

    doc.save(
        modo === 'completo'
            ? 'diagnostico-do-negocio-detalhado.pdf'
            : 'diagnostico-do-negocio-resumo.pdf',
    );
}

export default function DiagnosticoResultado({
    areas,
    respostas,
    resultado,
    liberado,
    pix,
}: DiagnosticoResultadoProps) {
    const [pixOpen, setPixOpen] = useState(false);

    const handleDownload = () =>
        gerarPdf(areas, respostas, resultado, 'completo');
    const handleDownloadResumo = () =>
        gerarPdf(areas, respostas, resultado, 'resumo');

    return (
        <>
            <Head title="Resultado do Diagnóstico" />

            <div className="mx-auto w-full max-w-6xl space-y-8 p-6">
                <header className="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                    <div className="flex items-center gap-3">
                        <div className="flex size-11 items-center justify-center rounded-xl bg-primary text-primary-foreground">
                            <Trophy className="size-6" />
                        </div>
                        <div>
                            <h1 className="text-2xl font-bold">
                                Resultado do Diagnóstico
                            </h1>
                            <p className="text-sm text-muted-foreground">
                                Veja a pontuação de cada área do seu negócio.
                            </p>
                        </div>
                    </div>
                    <div className="flex flex-wrap gap-3">
                        {liberado && (
                            <>
                                <Button onClick={handleDownloadResumo}>
                                    <Download className="size-4" />
                                    Gerar PDF
                                </Button>
                                <Button
                                    variant="outline"
                                    onClick={handleDownload}
                                >
                                    <Download className="size-4" />
                                    PDF detalhado
                                </Button>
                            </>
                        )}
                    </div>
                </header>

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
                                <CardTitle>Pontuação geral</CardTitle>
                                <CardDescription>
                                    Média das 7 áreas do negócio.
                                </CardDescription>
                            </CardHeader>
                            <CardContent className="flex items-end justify-between gap-4">
                                <div>
                                    <p className="text-5xl font-bold">
                                        {resultado.geral}
                                    </p>
                                    <p className="text-sm text-muted-foreground">
                                        de 100
                                    </p>
                                </div>
                                <Badge
                                    className={
                                        resultado.geral <= 40
                                            ? 'bg-red-500 text-white'
                                            : resultado.geral <= 70
                                              ? 'bg-yellow-500 text-black'
                                              : 'bg-green-500 text-white'
                                    }
                                >
                                    {resultado.faixa_geral_label}
                                </Badge>
                            </CardContent>
                            <CardContent>
                                <p className="text-sm leading-relaxed text-muted-foreground">
                                    <span className="font-bold">
                                        O que isso significa:{' '}
                                    </span>
                                    {faixaExplicacao[resultado.faixa_geral]}
                                </p>
                            </CardContent>
                        </Card>

                        {liberado ? (
                            <>
                                <Card>
                                    <CardHeader>
                                        <CardTitle className="flex items-center gap-2">
                                            <TrendingDown className="size-5 text-red-500" />
                                            Pontos mais críticos
                                        </CardTitle>
                                        <CardDescription>
                                            As 2 áreas com menor pontuação para
                                            priorizar agora.
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
                                                        className={`${
                                                            r.faixa ===
                                                            'critico'
                                                                ? 'bg-red-500 text-white'
                                                                : r.faixa ===
                                                                    'construcao'
                                                                  ? 'bg-yellow-500 text-black'
                                                                  : 'bg-green-500 text-white'
                                                        }`}
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
                                                        className={`${
                                                            r.faixa ===
                                                            'critico'
                                                                ? 'bg-red-500'
                                                                : r.faixa ===
                                                                    'construcao'
                                                                  ? 'bg-yellow-500'
                                                                  : 'bg-green-500'
                                                        } h-full`}
                                                        style={{
                                                            width: `${r.normalizado}%`,
                                                        }}
                                                    />
                                                </div>
                                                {r.texto && (
                                                    <p className="mt-3 text-sm leading-relaxed text-muted-foreground">
                                                        <span className="font-bold">
                                                            O que isso
                                                            significa:{' '}
                                                        </span>
                                                        {r.texto}
                                                    </p>
                                                )}
                                            </CardContent>
                                        </Card>
                                    ))}
                                </div>
                            </>
                        ) : (
                            <Card className="border-dashed">
                                <CardContent className="flex flex-col items-center gap-4 py-10 text-center">
                                    <Lock className="size-10 text-muted-foreground" />
                                    <div>
                                        <p className="font-semibold">
                                            Resultado detalhado bloqueado
                                        </p>
                                        <p className="text-sm text-muted-foreground">
                                            Pague via PIX para liberar o
                                            diagnóstico detalhado com todas as
                                            áreas, pontos criticos e o download
                                            do relatório.
                                        </p>
                                    </div>
                                    <Button
                                        className="bg-green-600 text-white hover:bg-green-700"
                                        onClick={() => setPixOpen(true)}
                                    >
                                        <QrCode className="size-4" />
                                        {pix.label}
                                    </Button>
                                </CardContent>
                            </Card>
                        )}

                        <Card className="border-primary/30 bg-primary/5">
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2 text-lg uppercase tracking-wide">
                                    <ArrowRight className="size-5 text-primary" />
                                    Próximo passo
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="space-y-1">
                                    <p className="text-2xl font-semibold">
                                        Seu raio-x mostrou onde estão os
                                        buracos.
                                    </p>
                                    <p className="text-2xl font-semibold">
                                        Agora é hora de resolver cada um deles.
                                    </p>
                                </div>

                                <p className="text-sm leading-relaxed text-muted-foreground">
                                    Esse diagnóstico aponta exatamente o que
                                    trava o crescimento do seu negócio como
                                    videomaker. Na Conexão Videomaker, você
                                    recebe um método dedicado, construído a
                                    partir de 16 anos de experiência no mercado,
                                    para estruturar posicionamento, atendimento,
                                    propostas, contratos e precificação — com a
                                    troca constante de todos os membros da
                                    comunidade te ajudando a evoluir mais
                                    rápido.
                                </p>

                                <ul className="grid gap-x-6 gap-y-2 sm:grid-cols-2">
                                    {[
                                        'Método passo a passo com 16 anos de estrada',
                                        'Modelos de proposta, contrato e precificação',
                                        'Comunidade ativa de videomakers trocando experiência',
                                        'Acompanhamento para sair do improviso e ganhar escala',
                                    ].map((item) => (
                                        <li
                                            key={item}
                                            className="flex items-start gap-2 text-sm"
                                        >
                                            <CheckCircle2 className="mt-0.5 size-4 shrink-0 text-primary" />
                                            <span>{item}</span>
                                        </li>
                                    ))}
                                </ul>

                                <p className="text-sm leading-relaxed text-muted-foreground">
                                    Na entrevista da mentoria, cada item do
                                    pilar é analisado junto com você.
                                </p>

                                <Button size="lg" asChild>
                                    <a
                                        href={
                                            'https://wa.me/5534991481041?text=' +
                                            encodeURIComponent(
                                                'Olá! Fiz o diagnóstico do meu negócio como videomaker e tenho interesse na mentoria.',
                                            )
                                        }
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        <MessageCircle className="size-5" />
                                        Tenho interesse na mentoria
                                    </a>
                                </Button>
                            </CardContent>
                        </Card>
                    </>
                )}
            </div>

            <PixDialog pix={pix} open={pixOpen} onOpenChange={setPixOpen} />
        </>
    );
}
