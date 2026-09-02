import InputError from '@/components/input-error';
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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    index as primeiroAcessoIndex,
    store as primeiroAcessoStore,
} from '@/routes/primeiro-acesso';
import { Head, useForm } from '@inertiajs/react';
import { UserCheck } from 'lucide-react';

type PrimeiroAcessoProps = {
    tipoAtual: string | null;
    tipos: Array<{ value: string; label: string }>;
    passwordRules: string;
};

type PrimeiroAcessoForm = {
    role: string;
    password: string;
    password_confirmation: string;
};

export default function PrimeiroAcesso({
    tipoAtual,
    tipos,
    passwordRules,
}: PrimeiroAcessoProps) {
    const { data, setData, post, errors, processing } =
        useForm<PrimeiroAcessoForm>({
            role: tipoAtual ?? 'cliente',
            password: '',
            password_confirmation: '',
        });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post(primeiroAcessoStore().url);
    };

    return (
        <>
            <Head title="Primeiro acesso" />

            <form
                onSubmit={submit}
                className="mx-auto w-full max-w-lg space-y-4"
            >
                <Card>
                    <CardHeader className="py-4">
                        <CardTitle className="flex items-center gap-2">
                            <UserCheck className="size-5" />
                            Primeiro acesso
                        </CardTitle>
                        <CardDescription>
                            Escolha seu tipo de usuário e defina uma senha
                            pessoal para continuar.
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="grid gap-2">
                            <Label>Tipo de usuário</Label>
                            <Select
                                value={data.role}
                                onValueChange={(v) => setData('role', v)}
                            >
                                <SelectTrigger className="w-full">
                                    <SelectValue placeholder="Selecione o tipo de usuário" />
                                </SelectTrigger>
                                <SelectContent>
                                    {tipos.map((t) => (
                                        <SelectItem
                                            key={t.value}
                                            value={t.value}
                                        >
                                            {t.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <InputError message={errors.role} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="password">Nova senha</Label>
                            <Input
                                id="password"
                                type="password"
                                value={data.password}
                                onChange={(e) =>
                                    setData('password', e.target.value)
                                }
                                autoComplete="new-password"
                                placeholder="Defina uma nova senha"
                            />
                            <InputError message={errors.password} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="password_confirmation">
                                Confirmar senha
                            </Label>
                            <Input
                                id="password_confirmation"
                                type="password"
                                value={data.password_confirmation}
                                onChange={(e) =>
                                    setData(
                                        'password_confirmation',
                                        e.target.value,
                                    )
                                }
                                autoComplete="new-password"
                            />
                            <InputError
                                message={errors.password_confirmation}
                            />
                        </div>

                        {passwordRules && (
                            <p className="text-xs text-muted-foreground">
                                Requisitos: {passwordRules}
                            </p>
                        )}

                        <div className="flex items-center justify-end">
                            <Button type="submit" disabled={processing}>
                                {processing
                                    ? 'Salvando...'
                                    : 'Concluir primeiro acesso'}
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <div className="text-center">
                    <a
                        href={primeiroAcessoIndex().url}
                        className="text-sm text-muted-foreground underline"
                    >
                        Atualize a página
                    </a>
                </div>
            </form>
        </>
    );
}
