import { Head, Link, usePage } from '@inertiajs/react';
import { dashboard, login, register } from '@/routes';
import { CountUp } from '@/components/count-up';

const steps = [
    {
        number: '01',
        title: 'Cadastre seu anuncio',
        description: 'Publique equipamentos ou servicos de producao audiovisual que deseja permutar.',
        icon: (
            <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        ),
    },
    {
        number: '02',
        title: 'Encontre seu match',
        description: 'Explore anuncios e crie matches com outros profissionais do mercado audiovisual.',
        icon: (
            <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        ),
    },
    {
        number: '03',
        title: 'Feche a permuta',
        description: 'Realize a troca direta, venda ou permuta por creditos de forma segura e transparente.',
        icon: (
            <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
            </svg>
        ),
    },
];

const categories = [
    { name: 'Cameras', emoji: '🎬' },
    { name: 'Lentes', emoji: '📷' },
    { name: 'Audio', emoji: '🎙️' },
    { name: 'Iluminacao', emoji: '💡' },
    { name: 'Drones', emoji: '🛸' },
    { name: 'Filmagem', emoji: '🎥' },
    { name: 'Edicao', emoji: '✂️' },
    { name: 'Fotografia', emoji: '📸' },
    { name: 'Streaming', emoji: '📡' },
];

const features = [
    {
        title: 'Permuta direta',
        description: 'Troque equipamentos e servicos diretamente com outros profissionais sem intermediarios.',
    },
    {
        title: 'Creditos',
        description: 'Nao tem o que outro quer? Use creditos no livro-razao para fechar permutas equilibradas.',
    },
    {
        title: 'Seguranca',
        description: 'Disputas resolvidas pelo administrador. Pagamentos registrados de forma transparente.',
    },
    {
        title: 'Comunidade',
        description: 'Conecte-se com profissionais do mercado audiovisual de todo o Brasil.',
    },
];

type WelcomeProps = {
    auth: { user: unknown };
    stats: {
        listings: number;
        users: number;
        matches: number;
    };
};

export default function Welcome({ stats }: WelcomeProps) {
    const { auth } = usePage().props;

    return (
        <>
            <Head title="Permuta Audiovisual - Marketplace de Equipamentos e Servicos" />

            <div className="flex min-h-screen flex-col bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100">
                <header className="flex-none border-b border-gray-100 dark:border-gray-800">
                    <div className="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                        <div className="flex items-center gap-2">
                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-900 text-white dark:bg-white dark:text-gray-900">
                                <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-2.625 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125-.504-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125m1.5 3.75c-.621 0-1.125-.504-1.125-1.125" />
                                </svg>
                            </div>
                            <span className="text-lg font-semibold tracking-tight">Permuta AV</span>
                        </div>

                        <nav className="hidden items-center gap-8 text-sm font-medium text-gray-600 dark:text-gray-400 md:flex">
                            <a href="#como-funciona" className="transition-colors hover:text-gray-900 dark:hover:text-white">Como funciona</a>
                            <a href="#categorias" className="transition-colors hover:text-gray-900 dark:hover:text-white">Categorias</a>
                            <a href="#vantagens" className="transition-colors hover:text-gray-900 dark:hover:text-white">Vantagens</a>
                        </nav>

                        <div className="flex items-center gap-3">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className="rounded-full bg-gray-900 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
                                >
                                    Painel
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={login()}
                                        className="rounded-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                                    >
                                        Entrar
                                    </Link>
                                    <Link
                                        href={register()}
                                        className="rounded-full bg-gray-900 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
                                    >
                                        Comecar agora
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </header>

                <main className="flex-1">
                    <section className="relative overflow-hidden px-6 py-24 lg:px-8">
                        <div className="absolute inset-0 -z-10">
                            <div className="absolute -top-40 left-1/2 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-gradient-to-b from-gray-200 to-transparent opacity-40 blur-3xl dark:from-gray-800"></div>
                        </div>
                        <div className="mx-auto max-w-4xl text-center">
                            <div className="mb-6 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-4 py-1.5 text-xs font-medium text-gray-600 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">
                                <span className="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Marketplace audiovisual
                            </div>
                            <h1 className="text-5xl font-bold tracking-tight sm:text-6xl lg:text-7xl">
                                Troque equipamentos.
                                <br />
                                <span className="bg-gradient-to-r from-gray-900 to-gray-500 bg-clip-text text-transparent dark:from-white dark:to-gray-400">
                                    Conecte producoes.
                                </span>
                            </h1>
                            <p className="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-gray-600 dark:text-gray-400">
                                O marketplace de permuta para o mercado audiovisual. Cadastre equipamentos e servicos,
                                encontre matches e feche trocas diretas, vendas ou permutas por creditos.
                            </p>
                            <div className="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                                <Link
                                    href={register()}
                                    className="inline-flex items-center gap-2 rounded-full bg-gray-900 px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition-all hover:shadow-xl hover:scale-[1.02] dark:bg-white dark:text-gray-900"
                                >
                                    Comecar a permutar
                                    <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </Link>
                                <a
                                    href="#como-funciona"
                                    className="inline-flex items-center gap-2 rounded-full border border-gray-300 px-8 py-3.5 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-900"
                                >
                                    Como funciona
                                </a>
                            </div>
                        </div>
                        <div className="mt-20 mx-auto grid max-w-5xl grid-cols-3 gap-px overflow-hidden rounded-2xl border border-gray-200 bg-gray-200 dark:border-gray-800 dark:bg-gray-800">
                            <div className="bg-white px-6 py-8 text-center dark:bg-gray-950">
                                <div className="text-3xl font-bold tracking-tight">
                                    <CountUp target={stats.listings} suffix="+" />
                                </div>
                                <div className="mt-1 text-sm text-gray-500 dark:text-gray-400">Anuncios ativos</div>
                            </div>
                            <div className="bg-white px-6 py-8 text-center dark:bg-gray-950">
                                <div className="text-3xl font-bold tracking-tight">
                                    <CountUp target={stats.users} suffix="+" />
                                </div>
                                <div className="mt-1 text-sm text-gray-500 dark:text-gray-400">Profissionais</div>
                            </div>
                            <div className="bg-white px-6 py-8 text-center dark:bg-gray-950">
                                <div className="text-3xl font-bold tracking-tight">
                                    <CountUp target={stats.matches} suffix="+" />
                                </div>
                                <div className="mt-1 text-sm text-gray-500 dark:text-gray-400">Permutas fechadas</div>
                            </div>
                        </div>
                    </section>

                    <section id="como-funciona" className="border-t border-gray-100 bg-gray-50/50 px-6 py-24 dark:border-gray-800 dark:bg-gray-900/30 lg:px-8">
                        <div className="mx-auto max-w-7xl">
                            <div className="mx-auto max-w-2xl text-center">
                                <h2 className="text-3xl font-bold tracking-tight sm:text-4xl">Como funciona</h2>
                                <p className="mt-4 text-lg text-gray-600 dark:text-gray-400">
                                    Tres passos simples para comecar a permutar
                                </p>
                            </div>
                            <div className="mx-auto mt-16 grid max-w-3xl gap-8">
                                {steps.map((step) => (
                                    <div key={step.number} className="relative flex gap-6">
                                        <div className="flex h-12 w-12 flex-none items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                            {step.icon}
                                        </div>
                                        <div>
                                            <div className="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                                Passo {step.number}
                                            </div>
                                            <h3 className="mt-1 text-lg font-semibold">{step.title}</h3>
                                            <p className="mt-2 text-gray-600 dark:text-gray-400">{step.description}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </section>

                    <section id="categorias" className="px-6 py-24 lg:px-8">
                        <div className="mx-auto max-w-7xl">
                            <div className="mx-auto max-w-2xl text-center">
                                <h2 className="text-3xl font-bold tracking-tight sm:text-4xl">Categorias</h2>
                                <p className="mt-4 text-lg text-gray-600 dark:text-gray-400">
                                    Equipamentos e servicos do mercado audiovisual
                                </p>
                            </div>
                            <div className="mx-auto mt-12 grid max-w-4xl grid-cols-3 gap-3 sm:grid-cols-5 sm:gap-4">
                                {categories.map((category) => (
                                    <div
                                        key={category.name}
                                        className="group flex flex-col items-center gap-2 rounded-2xl border border-gray-200 bg-white p-5 transition-all hover:border-gray-400 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-600"
                                    >
                                        <span className="text-2xl">{category.emoji}</span>
                                        <span className="text-sm font-medium text-gray-700 dark:text-gray-300">{category.name}</span>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </section>

                    <section id="vantagens" className="border-t border-gray-100 bg-gray-50/50 px-6 py-24 dark:border-gray-800 dark:bg-gray-900/30 lg:px-8">
                        <div className="mx-auto max-w-7xl">
                            <div className="mx-auto max-w-2xl text-center">
                                <h2 className="text-3xl font-bold tracking-tight sm:text-4xl">Vantagens</h2>
                                <p className="mt-4 text-lg text-gray-600 dark:text-gray-400">
                                    Por que permutar na Permuta AV
                                </p>
                            </div>
                            <div className="mx-auto mt-16 grid max-w-4xl gap-6 sm:grid-cols-2">
                                {features.map((feature) => (
                                    <div
                                        key={feature.title}
                                        className="rounded-2xl border border-gray-200 bg-white p-8 transition-all hover:shadow-md dark:border-gray-800 dark:bg-gray-900"
                                    >
                                        <h3 className="text-lg font-semibold">{feature.title}</h3>
                                        <p className="mt-3 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                            {feature.description}
                                        </p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </section>

                    <section className="px-6 py-24 lg:px-8">
                        <div className="mx-auto max-w-4xl">
                            <div className="relative overflow-hidden rounded-3xl bg-gray-900 px-8 py-16 text-center sm:px-16 dark:bg-white">
                                <div className="absolute -top-20 -right-20 h-64 w-64 rounded-full bg-white/5 dark:bg-gray-900/5"></div>
                                <div className="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-white/5 dark:bg-gray-900/5"></div>
                                <div className="relative">
                                    <h2 className="text-3xl font-bold tracking-tight text-white sm:text-4xl dark:text-gray-900">
                                        Pronto para permutar?
                                    </h2>
                                    <p className="mx-auto mt-4 max-w-xl text-gray-400 dark:text-gray-600">
                                        Junte-se a centenas de profissionais do audiovisual e comece a trocar equipamentos e servicos hoje.
                                    </p>
                                    <div className="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                                        <Link
                                            href={register()}
                                            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-3.5 text-sm font-semibold text-gray-900 shadow-lg transition-all hover:shadow-xl hover:scale-[1.02] dark:bg-gray-900 dark:text-white"
                                        >
                                            Criar conta gratuita
                                            <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                            </svg>
                                        </Link>
                                        <Link
                                            href={login()}
                                            className="inline-flex items-center gap-2 rounded-full border border-gray-700 px-8 py-3.5 text-sm font-semibold text-gray-300 transition-colors hover:bg-gray-800 dark:border-gray-300 dark:text-gray-700 dark:hover:bg-gray-100"
                                        >
                                            Ja tenho conta
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                <footer className="flex-none border-t border-gray-100 dark:border-gray-800">
                    <div className="mx-auto max-w-7xl px-6 py-12 lg:px-8">
                        <div className="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <div className="flex items-center gap-2">
                                <div className="flex h-6 w-6 items-center justify-center rounded-md bg-gray-900 text-white dark:bg-white dark:text-gray-900">
                                    <svg className="h-3 w-3" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-2.625 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125-.504-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125m1.5 3.75c-.621 0-1.125-.504-1.125-1.125" />
                                    </svg>
                                </div>
                                <span className="text-sm font-semibold">Permuta AV</span>
                            </div>
                            <p className="text-sm text-gray-500 dark:text-gray-400">
                                Marketplace de permuta para o mercado audiovisual
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}
