import { ActionIconButton } from '@/components/action-icon-button';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { SearchSelect } from '@/components/ui/search-select';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogTitle,
} from '@/components/ui/dialog';
import { registrations, verify, deactivate, destroy } from '@/routes/admin';
import { Form, Head, router } from '@inertiajs/react';
import {
    CheckCircle2,
    Clock,
    Mail,
    MapPin,
    Search,
    Trash2,
    UserX,
} from 'lucide-react';
import { useCallback, useRef, useState } from 'react';

interface RegistrationUser {
    id: number;
    name: string;
    email: string;
    region: string | null;
    city: string | null;
    role: string | null;
    verifiedAt: string | null;
    createdAt: string;
}

interface RoleOption {
    value: string;
    label: string;
}

interface Filters {
    nome?: string;
    cidade?: string;
    role?: string;
    pending?: boolean;
}

interface RegistrationsProps {
    users: RegistrationUser[];
    roles: RoleOption[];
    filters: Filters;
}

function roleLabel(role: string | null): string {
    switch (role) {
        case 'videomaker':
            return 'Videomaker';
        case 'cliente':
            return 'Cliente';
        case 'empresa':
            return 'Empresa';
        case 'administrador':
            return 'Administrador';
        default:
            return role ?? '-';
    }
}

function DeleteUserDialog({ user }: { user: RegistrationUser }) {
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
                <DialogTitle>Excluir cadastro?</DialogTitle>
                <DialogDescription>
                    O cadastro de {user.name} e todos os dados vinculados serão
                    excluídos permanentemente. Esta ação não pode ser desfeita.
                </DialogDescription>
                <DialogFooter>
                    <DialogClose asChild>
                        <Button type="button" variant="outline">
                            Cancelar
                        </Button>
                    </DialogClose>
                    <Form {...destroy.form(user.id)} resetOnSuccess>
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

export default function Registrations({
    users,
    roles,
    filters,
}: RegistrationsProps) {
    const [nome, setNome] = useState(filters.nome ?? '');
    const [cidade, setCidade] = useState(filters.cidade ?? '');
    const debounceRef = useRef<ReturnType<typeof setTimeout> | undefined>(
        undefined,
    );

    const applyFilter = useCallback(
        (key: string, value: string | boolean | undefined) => {
            const query: Record<string, string | boolean> = {};

            for (const [k, v] of Object.entries(filters)) {
                if (v !== undefined && v !== '' && v !== false) {
                    query[k] = v;
                }
            }

            if (value === undefined || value === '') {
                delete query[key];
            } else {
                query[key] = value === false ? false : value;
            }

            router.get(registrations({ query }).url, undefined, {
                preserveState: true,
                replace: true,
            });
        },
        [filters],
    );

    const handleDebouncedFilter = useCallback(
        (key: 'nome' | 'cidade', setter: (v: string) => void, value: string) => {
            setter(value);
            clearTimeout(debounceRef.current);
            debounceRef.current = setTimeout(() => {
                applyFilter(key, value || undefined);
            }, 400);
        },
        [applyFilter],
    );

    const activeFiltersCount = [
        filters.nome,
        filters.cidade,
        filters.role,
        filters.pending ? 'pending' : null,
    ].filter(Boolean).length;

    return (
        <>
            <Head title="Cadastros" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <h1 className="text-lg font-semibold">
                    Cadastros
                    {activeFiltersCount > 0 && (
                        <span className="ml-2 text-sm font-normal text-muted-foreground">
                            {users.length} resultado(s)
                        </span>
                    )}
                </h1>

                <div className="flex flex-col gap-3 rounded-xl border bg-card p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-end">
                        <div className="flex w-full flex-col gap-1.5 sm:w-64">
                            <Label className="text-xs text-muted-foreground">
                                Nome
                            </Label>
                            <div className="relative">
                                <Search className="absolute left-2.5 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    placeholder="Buscar por nome..."
                                    value={nome}
                                    onChange={(e) =>
                                        handleDebouncedFilter('nome', setNome, e.target.value)
                                    }
                                    className="pl-8"
                                />
                            </div>
                        </div>
                        <div className="flex w-full flex-col gap-1.5 sm:w-64">
                            <Label className="text-xs text-muted-foreground">
                                Cidade
                            </Label>
                            <Input
                                placeholder="Cidade..."
                                value={cidade}
                                onChange={(e) =>
                                    handleDebouncedFilter('cidade', setCidade, e.target.value)
                                }
                            />
                        </div>
                        <div className="flex flex-col gap-1.5 sm:w-52">
                            <Label className="text-xs text-muted-foreground">
                                Nível
                            </Label>
                            <SearchSelect
                                options={roles.map((r) => ({
                                    value: r.value,
                                    label: r.label,
                                }))}
                                value={filters.role ?? ''}
                                onValueChange={(v) => applyFilter('role', v)}
                                placeholder="Todos"
                                clearable
                            />
                        </div>
                        <label className="flex cursor-pointer items-center gap-2 pb-2 text-sm">
                            <input
                                type="checkbox"
                                checked={filters.pending ?? false}
                                onChange={(e) =>
                                    applyFilter('pending', e.target.checked || undefined)
                                }
                            />
                            Somente pendentes
                        </label>
                    </div>
                </div>

                {users.length === 0 ? (
                    <div className="flex items-center justify-center rounded-xl border border-sidebar-border/70 p-12 text-sm text-muted-foreground dark:border-sidebar-border">
                        Nenhum cadastro encontrado.
                    </div>
                ) : (
                    <div className="overflow-hidden rounded-xl border bg-card shadow-sm">
                        <div className="hidden grid-cols-12 gap-4 border-b bg-muted/50 px-5 py-3 text-xs font-medium uppercase tracking-wide text-muted-foreground md:grid">
                            <div className="col-span-4">Usuário</div>
                            <div className="col-span-3">Cidade</div>
                            <div className="col-span-2">Nível</div>
                            <div className="col-span-2">Status</div>
                            <div className="col-span-1 text-right">Ações</div>
                        </div>
                        <ul className="divide-y divide-border">
                            {users.map((user) => (
                                <li
                                    key={user.id}
                                    className="grid grid-cols-1 gap-3 px-5 py-4 transition-colors hover:bg-muted/30 md:grid-cols-12 md:items-center md:gap-4"
                                >
                                    <div className="col-span-4 flex flex-col gap-1">
                                        <h3 className="text-sm font-medium">
                                            {user.name}
                                        </h3>
                                        <span className="flex items-center gap-1 text-xs text-muted-foreground">
                                            <Mail className="size-3" />
                                            {user.email}
                                        </span>
                                    </div>

                                    <div className="col-span-3 flex items-center gap-1 text-sm text-muted-foreground">
                                        <MapPin className="size-3.5" />
                                        {user.city && user.region
                                            ? `${user.city} - ${user.region}`
                                            : '-'}
                                    </div>

                                    <div className="col-span-2">
                                        <Badge variant="outline">
                                            {roleLabel(user.role)}
                                        </Badge>
                                    </div>

                                    <div className="col-span-2">
                                        {user.verifiedAt ? (
                                            <Badge
                                                variant="default"
                                                className="bg-green-600 hover:bg-green-700"
                                            >
                                                <CheckCircle2 className="size-3" />{' '}
                                                Verificado
                                            </Badge>
                                        ) : (
                                            <Badge variant="secondary">
                                                <Clock className="size-3" />{' '}
                                                Pendente
                                            </Badge>
                                        )}
                                    </div>

                                    <div className="col-span-1 flex justify-end gap-1">
                                        {!user.verifiedAt ? (
                                            <ActionIconButton
                                                icon={CheckCircle2}
                                                label="Aceitar"
                                                form={verify.form(user.id)}
                                            />
                                        ) : (
                                            <ActionIconButton
                                                icon={UserX}
                                                label="Desativar"
                                                variant="outline"
                                                className="text-destructive hover:text-destructive"
                                                form={deactivate.form(user.id)}
                                            />
                                        )}

                                        <DeleteUserDialog user={user} />
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

Registrations.layout = {
    breadcrumbs: [
        {
            title: 'Cadastros',
            href: registrations(),
        },
    ],
};