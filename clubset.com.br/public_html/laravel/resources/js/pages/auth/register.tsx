import InputError from '@/components/input-error';
import PasswordInput from '@/components/password-input';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { Form, Head } from '@inertiajs/react';
import { Building2, Camera, Clapperboard } from 'lucide-react';
import { useState } from 'react';

const roles = [
    {
        value: 'videomaker',
        label: 'Videomaker',
        description:
            'Ofereça serviços, participe de matches e publique equipamentos para troca ou venda.',
        icon: Clapperboard,
    },
    {
        value: 'cliente',
        label: 'Cliente',
        description:
            'Busque freelancers na sua região para contratação de serviços audiovisuais.',
        icon: Camera,
    },
    {
        value: 'empresa',
        label: 'Empresa',
        description:
            'Participe de permutas diretas ou por creditos com outros profissionais.',
        icon: Building2,
    },
];

export default function Register() {
    const [selectedRole, setSelectedRole] = useState('videomaker');

    return (
        <>
            <Head title="Registrar" />
            <Form
                {...store.form()}
                resetOnSuccess={['password', 'password_confirmation']}
                disableWhileProcessing
                className="flex flex-col gap-6"
                initialData={{ role: 'videomaker' }}
            >
                {({ processing, errors }) => (
                    <>
                        <div className="grid gap-6">
                            <div className="grid gap-2">
                                <Label>Você é</Label>
                                <div className="grid gap-3 sm:grid-cols-3">
                                    {roles.map((role) => {
                                        const Icon = role.icon;
                                        const isSelected =
                                            selectedRole === role.value;
                                        return (
                                            <label
                                                key={role.value}
                                                className={`relative flex cursor-pointer flex-col items-center gap-2 rounded-xl border p-4 text-center transition-all ${
                                                    isSelected
                                                        ? 'border-gray-900 bg-gray-50 dark:border-white dark:bg-gray-900'
                                                        : 'border-gray-200 bg-white hover:border-gray-400 dark:border-gray-800 dark:bg-gray-950 dark:hover:border-gray-600'
                                                }`}
                                            >
                                                <input
                                                    type="radio"
                                                    name="role"
                                                    value={role.value}
                                                    checked={isSelected}
                                                    onChange={() => {
                                                        setSelectedRole(
                                                            role.value,
                                                        );
                                                    }}
                                                    className="sr-only"
                                                />
                                                <div
                                                    className={`flex h-10 w-10 items-center justify-center rounded-lg ${
                                                        isSelected
                                                            ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                                                            : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'
                                                    }`}
                                                >
                                                    <Icon className="h-5 w-5" />
                                                </div>
                                                <span className="text-sm font-semibold">
                                                    {role.label}
                                                </span>
                                                <span className="text-xs leading-relaxed text-gray-500 dark:text-gray-400">
                                                    {role.description}
                                                </span>
                                            </label>
                                        );
                                    })}
                                </div>
                                <InputError
                                    message={errors.role}
                                    className="mt-1"
                                />
                            </div>

                            <div className="grid gap-4 sm:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Nome</Label>
                                    <Input
                                        id="name"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="name"
                                        name="name"
                                        placeholder="Nome completo"
                                    />
                                    <InputError message={errors.name} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="email">
                                        Endereço de email
                                    </Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        required
                                        tabIndex={2}
                                        autoComplete="email"
                                        name="email"
                                        placeholder="email@exemplo.com"
                                    />
                                    <InputError message={errors.email} />
                                </div>
                            </div>

                            <div className="grid gap-4 sm:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label htmlFor="password">Senha</Label>
                                    <PasswordInput
                                        id="password"
                                        required
                                        tabIndex={3}
                                        autoComplete="new-password"
                                        name="password"
                                        placeholder="Senha"
                                    />
                                    <InputError message={errors.password} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="password_confirmation">
                                        Confirmar senha
                                    </Label>
                                    <PasswordInput
                                        id="password_confirmation"
                                        required
                                        tabIndex={4}
                                        autoComplete="new-password"
                                        name="password_confirmation"
                                        placeholder="Confirmar senha"
                                    />
                                    <InputError
                                        message={errors.password_confirmation}
                                    />
                                </div>
                            </div>

                            <Button
                                type="submit"
                                className="mt-2 w-full"
                                tabIndex={5}
                                data-test="register-user-button"
                            >
                                {processing && <Spinner />}
                                Criar conta
                            </Button>
                        </div>

                        <div className="text-center text-sm text-muted-foreground">
                            Já tem uma conta?{' '}
                            <TextLink href={login()} tabIndex={6}>
                                Entrar
                            </TextLink>
                        </div>
                    </>
                )}
            </Form>
        </>
    );
}

Register.layout = {
    title: 'Registrar',
    description: 'Crie uma conta',
};
