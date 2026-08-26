import { Head, useForm } from '@inertiajs/react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { dashboard } from '@/routes';

type Settings = {
    listings: Record<string, string | null>;
    services: Record<string, string | null>;
    platform: Record<string, string | null>;
};

export default function AdminSettings({ settings }: { settings: Settings }) {
    const { data, setData, processing, patch } = useForm({
        settings: {
            listings: {
                max_images: settings.listings.max_images ?? '5',
                max_description_length: settings.listings.max_description_length ?? '5000',
                require_moderation: settings.listings.require_moderation ?? 'true',
            },
            services: {
                require_moderation: settings.services.require_moderation ?? 'false',
            },
            platform: {
                name: settings.platform.name ?? '',
            },
        },
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        patch('/admin/configuracoes');
    };

    return (
        <>
            <Head title="Configurações da Plataforma" />

            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
                <Heading
                    title="Configurações da Plataforma"
                    description="Configure limites e regras gerais do marketplace"
                />

                <form onSubmit={submit} className="space-y-8">
                    <div className="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                        <h3 className="mb-4 text-lg font-semibold">Anúncios</h3>
                        <div className="space-y-4">
                            <div className="grid items-start gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div className="space-y-1.5">
                                    <Label htmlFor="max_images">Máx. imagens por anúncio</Label>
                                    <Input
                                        id="max_images"
                                        type="number"
                                        min={1}
                                        max={20}
                                        value={data.settings.listings.max_images}
                                        onChange={(e) =>
                                            setData('settings', {
                                                ...data.settings,
                                                listings: {
                                                    ...data.settings.listings,
                                                    max_images: e.target.value,
                                                },
                                            })
                                        }
                                    />
                                    <p className="text-xs text-muted-foreground">
                                        Quantidade máxima de fotos que o usuário pode enviar por anúncio.
                                    </p>
                                </div>

                                <div className="space-y-1.5">
                                    <Label htmlFor="max_description_length">Máx. caracteres na descrição</Label>
                                    <Input
                                        id="max_description_length"
                                        type="number"
                                        min={100}
                                        max={10000}
                                        value={data.settings.listings.max_description_length}
                                        onChange={(e) =>
                                            setData('settings', {
                                                ...data.settings,
                                                listings: {
                                                    ...data.settings.listings,
                                                    max_description_length: e.target.value,
                                                },
                                            })
                                        }
                                    />
                                </div>

                                <div className="space-y-1.5">
                                    <Label>Moderação obrigatória</Label>
                                    <select
                                        value={data.settings.listings.require_moderation}
                                        onChange={(e) =>
                                            setData('settings', {
                                                ...data.settings,
                                                listings: {
                                                    ...data.settings.listings,
                                                    require_moderation: e.target.value,
                                                },
                                            })
                                        }
                                        className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        <option value="true">Sim — anúncios precisam de aprovação</option>
                                        <option value="false">Não — publicar automaticamente</option>
                                    </select>
                                    <p className="text-xs text-muted-foreground">
                                        Se ativo, novos anúncios ficam pendentes até um administrador aprovar.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                        <h3 className="mb-4 text-lg font-semibold">Serviços</h3>
                        <div className="space-y-4">
                            <div className="grid items-start gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div className="space-y-1.5">
                                    <Label>Moderação obrigatória</Label>
                                    <select
                                        value={data.settings.services.require_moderation}
                                        onChange={(e) =>
                                            setData('settings', {
                                                ...data.settings,
                                                services: {
                                                    ...data.settings.services,
                                                    require_moderation: e.target.value,
                                                },
                                            })
                                        }
                                        className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        <option value="true">Sim — serviços precisam de aprovação</option>
                                        <option value="false">Não — publicar automaticamente</option>
                                    </select>
                                    <p className="text-xs text-muted-foreground">
                                        Se ativo, novos serviços ficam pendentes até um administrador aprovar.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="flex justify-end">
                        <Button type="submit" disabled={processing}>
                            {processing && <Spinner />}
                            Salvar configurações
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
}

AdminSettings.layout = {
    breadcrumbs: [
        {
            title: 'Painel',
            href: dashboard(),
        },
        {
            title: 'Config. Plataforma',
            href: '/admin/configuracoes',
        },
    ],
};
