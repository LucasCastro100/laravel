import { Head, Form } from '@inertiajs/react';
import { CheckCircle2, Clock, Mail, MapPin, ShieldCheck, User } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { registrations as registrationsRoute, verify } from '@/routes/admin';

interface RegistrationUser {
    id: number;
    name: string;
    email: string;
    region: string;
    city: string;
    role: string | null;
    verifiedAt: string | null;
    createdAt: string;
}

interface RegistrationsProps {
    users: RegistrationUser[];
}

function roleLabel(role: string | null): string {
    switch (role) {
        case 'videomaker':
            return 'Videomaker';
        case 'cliente':
            return 'Cliente';
        case 'empresa':
            return 'Empresa';
        default:
            return role ?? '-';
    }
}

export default function Registrations({ users }: RegistrationsProps) {
    return (
        <>
            <Head title="Cadastros" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <h1 className="text-lg font-semibold">Cadastros</h1>

                {users.length === 0 ? (
                    <div className="flex items-center justify-center rounded-xl border border-sidebar-border/70 p-12 text-sm text-muted-foreground dark:border-sidebar-border">
                        Nenhum cadastro encontrado.
                    </div>
                ) : (
                    <div className="grid gap-4 md:grid-cols-2">
                        {users.map((user) => (
                            <Card key={user.id}>
                                <CardHeader className="flex flex-row items-start justify-between space-y-0">
                                    <CardTitle className="text-sm font-medium">
                                        {user.name}
                                    </CardTitle>
                                    {user.verifiedAt ? (
                                        <Badge variant="default" className="bg-green-600 hover:bg-green-700">
                                            <CheckCircle2 className="size-3" /> Verificado
                                        </Badge>
                                    ) : (
                                        <Badge variant="secondary">
                                            <Clock className="size-3" /> Pendente
                                        </Badge>
                                    )}
                                </CardHeader>
                                <CardContent className="space-y-2 text-sm">
                                    <div className="flex items-center gap-2 text-muted-foreground">
                                        <Mail className="size-4" />
                                        <span>{user.email}</span>
                                    </div>

                                    <div className="flex items-center gap-2 text-muted-foreground">
                                        <MapPin className="size-4" />
                                        <span>{user.city}, {user.region}</span>
                                    </div>

                                    <div className="flex items-center gap-2 text-muted-foreground">
                                        <User className="size-4" />
                                        <span>{roleLabel(user.role)}</span>
                                    </div>

                                    {user.verifiedAt && (
                                        <div className="flex items-center gap-2 text-muted-foreground">
                                            <ShieldCheck className="size-4" />
                                            <span>Verificado em {new Date(user.verifiedAt).toLocaleDateString('pt-BR')}</span>
                                        </div>
                                    )}

                                    <div className="pt-2 text-xs text-muted-foreground">
                                        Cadastrado {user.createdAt}
                                    </div>

                                    {!user.verifiedAt && (
                                        <div className="pt-2">
                                            <Form {...verify.form(user.id)}>
                                                <Button type="submit" size="sm">
                                                    <CheckCircle2 className="size-4" />
                                                    Verificar
                                                </Button>
                                            </Form>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>
                        ))}
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
            href: registrationsRoute(),
        },
    ],
};
