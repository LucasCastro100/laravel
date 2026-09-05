import { ActionIconButton } from '@/components/action-icon-button';
import { EmptyState } from '@/components/empty-state';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogTitle,
} from '@/components/ui/dialog';
import { diagnosticos as diagnosticosIndex } from '@/routes/admin';
import {
    destroy as diagnosticoDestroy,
    release as diagnosticoRelease,
    show as diagnosticoShow,
} from '@/routes/admin/diagnosticos';
import { Form, Head } from '@inertiajs/react';
import {
    AtSign,
    ClipboardList,
    Eye,
    Lock,
    LockOpen,
    MapPin,
    MessageCircle,
    Phone,
    Trash2,
    Users,
    Wallet,
} from 'lucide-react';
import { useState } from 'react';

interface DiagnosticoItem {
    uuid: string;
    nome: string;
    instagram: string;
    celular: string;
    estado: string | null;
    municipio: string | null;
    participaGrupo: boolean;
    grupoQual: string | null;
    renda: string;
    geral: number | null;
    faixaGeral: string | null;
    faixaGeralLabel: string | null;
    resultadoLiberado: boolean;
    criadoEm: string | null;
}

interface DiagnosticosProps {
    diagnosticos: DiagnosticoItem[];
}

function faixaBadge(faixa: string | null) {
    if (faixa === 'critico') {
        return <Badge className="bg-red-600 hover:bg-red-700">Crítico</Badge>;
    }
    if (faixa === 'construcao') {
        return (
            <Badge className="bg-yellow-500 text-black hover:bg-yellow-500">
                Em construção
            </Badge>
        );
    }
    if (faixa === 'solido') {
        return (
            <Badge className="bg-green-600 hover:bg-green-700">Sólido</Badge>
        );
    }
    return <Badge variant="secondary">-</Badge>;
}

function DeleteDiagnosticoDialog({
    nome,
    uuid,
}: {
    nome: string;
    uuid: string;
}) {
    const [open, setOpen] = useState(false);

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <ActionIconButton
                icon={Trash2}
                label="Excluir"
                variant="outline"
                className="text-destructive hover:text-destructive"
                onClick={() => setOpen(true)}
            />
            <DialogContent>
                <DialogTitle>Excluir diagnóstico?</DialogTitle>
                <DialogDescription>
                    O diagnóstico de {nome} será excluído permanentemente. Esta
                    ação não pode ser desfeita.
                </DialogDescription>
                <DialogFooter>
                    <DialogClose asChild>
                        <Button type="button" variant="outline">
                            Cancelar
                        </Button>
                    </DialogClose>
                    <Form {...diagnosticoDestroy.form(uuid)} resetOnSuccess>
                        {({ processing }) => (
                            <Button
                                type="submit"
                                variant="destructive"
                                disabled={processing}
                            >
                                Excluir
                            </Button>
                        )}
                    </Form>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}

export default function Diagnosticos({ diagnosticos }: DiagnosticosProps) {
    return (
        <>
            <Head title="Diagnósticos" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <Heading
                        variant="small"
                        title="Diagnósticos"
                        description="Acompanhe os diagnósticos de negócio enviados pelos usuários"
                    />
                </div>

                <div className="grid gap-4 sm:grid-cols-3">
                    <Card>
                        <CardContent className="space-y-1 p-5">
                            <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                <ClipboardList className="size-4" />
                                Total
                            </div>
                            <p className="text-2xl font-semibold">
                                {diagnosticos.length}
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="space-y-1 p-5">
                            <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                <Users className="size-4" />
                                No grupo WhatsApp
                            </div>
                            <p className="text-2xl font-semibold">
                                {
                                    diagnosticos.filter((d) => d.participaGrupo)
                                        .length
                                }
                            </p>
                        </CardContent>
                    </Card>
                </div>

                {diagnosticos.length === 0 ? (
                    <EmptyState
                        icon={ClipboardList}
                        title="Nenhum diagnóstico"
                        description="Nenhum diagnóstico foi enviado ainda."
                    />
                ) : (
                    <div className="overflow-hidden rounded-xl border bg-card shadow-sm">
                        <div className="hidden grid-cols-12 gap-4 border-b bg-muted/50 px-5 py-3 text-xs font-medium uppercase tracking-wide text-muted-foreground md:grid">
                            <div className="col-span-3">Usuário</div>
                            <div className="col-span-2">Telefone</div>
                            <div className="col-span-2">Resultado</div>
                            <div className="col-span-2">Faixa</div>
                            <div className="col-span-1">Grupo</div>
                            <div className="col-span-2 text-right">Ações</div>
                        </div>
                        <ul className="divide-y divide-border">
                            {diagnosticos.map((d) => (
                                <li
                                    key={d.uuid}
                                    className="grid grid-cols-1 gap-3 px-5 py-4 transition-colors hover:bg-muted/30 md:grid-cols-12 md:items-center md:gap-4"
                                >
                                    <div className="col-span-3 flex flex-col gap-1">
                                        <h3 className="text-sm font-medium">
                                            {d.nome}
                                        </h3>
                                        <div className="flex flex-wrap gap-x-3 gap-y-0.5 text-xs text-muted-foreground">
                                            <span className="flex items-center gap-1">
                                                <AtSign className="size-3" />
                                                {d.instagram}
                                            </span>
                                            <span className="flex items-center gap-1">
                                                <Wallet className="size-3" />
                                                {d.renda}
                                            </span>
                                            <span className="flex items-center gap-1">
                                                <MapPin className="size-3" />
                                                {[d.municipio, d.estado]
                                                    .filter(Boolean)
                                                    .join(', ') || '-'}
                                            </span>
                                        </div>
                                    </div>

                                    <div className="col-span-2 flex items-center gap-1 text-sm text-muted-foreground">
                                        <Phone className="size-3.5" />
                                        {d.celular}
                                    </div>

                                    <div className="col-span-2 text-base font-semibold">
                                        {d.geral ?? '-'}
                                        <span className="text-xs font-normal text-muted-foreground">
                                            {' '}
                                            / 100
                                        </span>
                                    </div>

                                    <div className="col-span-2">
                                        {faixaBadge(d.faixaGeral)}
                                    </div>

                                    <div className="col-span-1">
                                        {d.participaGrupo ? (
                                            <Badge className="bg-green-600 hover:bg-green-700">
                                                <MessageCircle className="size-3" />
                                                Sim
                                            </Badge>
                                        ) : (
                                            <Badge variant="secondary">
                                                Não
                                            </Badge>
                                        )}
                                    </div>

                                    <div className="col-span-2 flex flex-wrap justify-end gap-1">
                                        {d.resultadoLiberado ? (
                                            <ActionIconButton
                                                icon={LockOpen}
                                                label="Resultado liberado"
                                                className="bg-green-600 text-white hover:bg-green-700"
                                            />
                                        ) : (
                                            <ActionIconButton
                                                icon={Lock}
                                                label="Liberar resultado"
                                                form={diagnosticoRelease.form({
                                                    uuid: d.uuid,
                                                })}
                                            />
                                        )}
                                        <ActionIconButton
                                            icon={Eye}
                                            label="Ver resultado"
                                            variant="outline"
                                            href={
                                                diagnosticoShow({
                                                    uuid: d.uuid,
                                                }).url
                                            }
                                        />
                                        <DeleteDiagnosticoDialog
                                            nome={d.nome}
                                            uuid={d.uuid}
                                        />
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

Diagnosticos.layout = {
    breadcrumbs: [
        {
            title: 'Diagnósticos',
            href: diagnosticosIndex(),
        },
    ],
};
