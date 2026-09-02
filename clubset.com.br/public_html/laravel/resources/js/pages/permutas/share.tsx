import { Badge } from '@/components/ui/badge';
import { Card, CardContent } from '@/components/ui/card';
import { Head } from '@inertiajs/react';
import { Repeat } from 'lucide-react';

interface PermutaShareProps {
    permuta: {
        id: number;
        titulo: string | null;
        descricao: string | null;
        formattedValor: string;
        data: string | null;
        statusLabel: string;
        isCreator: boolean;
        contato: { nome: string; ehUsuario: boolean };
    };
}

export default function PermutaShare({ permuta }: PermutaShareProps) {
    return (
        <>
            <Head title={permuta.titulo ?? 'Permuta'} />

            <div className="flex min-h-screen items-center justify-center bg-muted/40 p-4">
                <Card className="w-full max-w-md">
                    <CardContent className="space-y-4 p-6">
                        <div className="flex items-center gap-2">
                            <Repeat className="size-5 text-primary" />
                            <h1 className="text-lg font-semibold">
                                {permuta.titulo ?? `Permuta #${permuta.id}`}
                            </h1>
                        </div>

                        <Badge variant="secondary">{permuta.statusLabel}</Badge>

                        <dl className="space-y-2 rounded-md bg-muted p-4 text-sm">
                            <div className="flex justify-between">
                                <dt className="text-muted-foreground">Valor</dt>
                                <dd className="font-semibold">
                                    {permuta.formattedValor}
                                </dd>
                            </div>
                            <div className="flex justify-between">
                                <dt className="text-muted-foreground">Data</dt>
                                <dd>{permuta.data ?? '—'}</dd>
                            </div>
                            <div className="flex justify-between">
                                <dt className="text-muted-foreground">
                                    Lado vinculado
                                </dt>
                                <dd className="font-medium">
                                    {permuta.contato.nome}
                                </dd>
                            </div>
                        </dl>

                        {permuta.descricao && (
                            <p className="text-sm text-muted-foreground">
                                {permuta.descricao}
                            </p>
                        )}

                        <p className="text-center text-xs text-muted-foreground">
                            Permuta compartilhada via ClubSet
                        </p>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
