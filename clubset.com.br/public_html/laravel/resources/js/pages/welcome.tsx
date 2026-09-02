import { login, register } from '@/routes';
import { Head, Link } from '@inertiajs/react';

export default function Welcome() {
    // Plans are hidden for now; set to true to show the plans section again.
    const showPlans = false;

    return (
        <>
            <Head title="Clubset — Portal do Audiovisual" />

            <div className="flex min-h-screen flex-col overflow-x-hidden bg-[#060b10] text-[#f4f1ea] antialiased [font-family:'Inter',sans-serif] [background:radial-gradient(ellipse_900px_520px_at_50%_-10%,#0e2a2e_0%,transparent_60%),linear-gradient(180deg,#060b10_0%,#0a1a1c_55%,#060b10_100%)]">
                <header className="flex-none">
                    <div className="mx-auto w-full max-w-[920px] px-6">
                        <div className="flex items-center justify-center gap-2.5 pt-16">
                            <div className="flex items-center gap-3">
                                <span className="font-['Space_Grotesk'] text-[26px] font-bold tracking-tight text-[#f4f1ea]">
                                    Clubset
                                </span>
                                <span className="-skew-x-6 rounded-[3px] bg-[#f2a63d] px-[11px] py-[5px] font-['Space_Grotesk'] text-[12px] font-semibold tracking-[.06em] text-[#060b10]">
                                    <span className="inline-block skew-x-6">
                                        PORTAL AUDIOVISUAL
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </header>

                <main className="flex-none">
                    <section className="px-6">
                        <div className="mx-auto max-w-[920px]">
                            <div className="pt-11 pb-2 text-center">
                                <h1 className="mx-auto max-w-[880px] font-['Space_Grotesk'] text-[clamp(34px,5.2vw,58px)] font-semibold leading-[1.12] tracking-[-.01em]">
                                    Prospecção, permuta e vitrine de equipamento
                                    em{' '}
                                    <em className="bg-[linear-gradient(180deg,transparent_62%,#c8863020_62%)] font-normal not-italic text-[#f2a63d]">
                                        um único portal.
                                    </em>
                                </h1>
                                <p className="mx-auto mt-[26px] max-w-[620px] text-[18px] leading-[1.6] text-[#93a6a8]">
                                    Mesmo que você{' '}
                                    <strong className="font-semibold text-[#f4f1ea]">
                                        trabalhe sozinho
                                    </strong>
                                    , não tenha equipe comercial e esteja cansado
                                    de fazer permuta{' '}
                                    <strong className="font-semibold text-[#f4f1ea]">
                                        sem controle
                                    </strong>{' '}
                                    ou fiado. O Clubset foi feito para quem vive
                                    do audiovisual de eventos e indústria.
                                </p>
                                <div className="mt-[34px] flex flex-col items-center justify-center gap-[14px] sm:flex-row">
                                    <Link
                                        href={login()}
                                        className="rounded-md bg-[#f2a63d] px-[26px] py-[14px] font-['Space_Grotesk'] text-[15px] font-semibold text-[#060b10] transition-opacity hover:opacity-90"
                                    >
                                        Entrar no Clubset
                                    </Link>
                                    <Link
                                        href="#planos"
                                        className="rounded-md border border-[#1c2e30] bg-transparent px-[26px] py-[14px] font-['Space_Grotesk'] text-[15px] font-semibold text-[#f4f1ea] transition-colors hover:border-[#3fd6c9]/50"
                                    >
                                        Ver como funciona
                                    </Link>
                                </div>
                            </div>

                            <div className="relative mt-16 border-y border-[#1c2e30]">
                                <div className="absolute inset-x-0 top-[-1px] h-[2px] bg-[repeating-linear-gradient(90deg,#3fd6c9_0_3px,transparent_3px_9px)] opacity-55"></div>
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                                    <Capability
                                        number="Região"
                                        title="Prospecção local"
                                        description="Encontre clientes e freelancers de audiovisual perto de você."
                                    />
                                    <Capability
                                        number="Permuta"
                                        title="Troca bilateral"
                                        description="Registre e controle permutas de serviço sem depender de acordo verbal."
                                    />
                                    <Capability
                                        number="Equipamento"
                                        title="Vitrine do setor"
                                        description="Compre, venda e alugue equipamento direto com outros membros."
                                    />
                                    <Capability
                                        number="Formação"
                                        title="Escola de negócios"
                                        description="Aprenda a precificar e vender audiovisual para eventos e indústria."
                                    />
                                </div>
                            </div>

                            <div className="flex justify-center py-14 sm:pb-24">
                                <div className="w-full min-[640px]:w-[640px] overflow-hidden rounded-t-[14px] rounded-b-[4px] border border-[#1c2e30] bg-[#0a1517] shadow-[0_40px_100px_-30px_rgba(0,0,0,.7)]">
                                    <div className="flex items-center gap-1.5 border-b border-[#1c2e30] bg-[#0d1c1f] px-[14px] py-[11px]">
                                        <span className="h-[9px] w-[9px] rounded-full bg-[#2a3d40]"></span>
                                        <span className="h-[9px] w-[9px] rounded-full bg-[#2a3d40]"></span>
                                        <span className="h-[9px] w-[9px] rounded-full bg-[#2a3d40]"></span>
                                    </div>
                                    <div className="relative flex aspect-[16/10] items-center justify-center bg-[radial-gradient(circle_at_30%_20%,#123a3d_0%,transparent_45%),radial-gradient(circle_at_75%_80%,#1a1010_0%,transparent_50%),#0b171a]">
                                        <div className="flex h-[62px] w-[62px] items-center justify-center rounded-full bg-[#f2a63d] shadow-[0_0_0_12px_rgba(242,166,61,.08)]">
                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="#060b10"
                                                className="ml-[3px] h-5 w-5"
                                            >
                                                <path d="M6 4l14 8-14 8V4z" />
                                            </svg>
                                        </div>
                                        <div className="absolute inset-x-[18px] bottom-4 flex justify-between font-['Space_Grotesk'] text-[11px] tracking-[.04em] text-[#93a6a8]">
                                            <span>Clubset · Painel do membro</span>
                                            <span>02:14</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {showPlans && (
                        <section
                            id="planos"
                            className="relative overflow-hidden px-6 py-24 lg:px-8"
                        >
                            <div className="pointer-events-none absolute inset-0 -z-10 bg-[#060b10]">
                                <div className="absolute inset-0 bg-[radial-gradient(ellipse_900px_520px_at_50%_-10%,#0e2a2e_0%,transparent_60%),linear-gradient(180deg,#060b10_0%,#0a1a1c_55%,#060b10_100%)]"></div>
                            </div>
                            <div className="mx-auto max-w-6xl">
                                <div className="mx-auto max-w-2xl text-center">
                                    <h2 className="font-['Space_Grotesk'] text-4xl font-semibold tracking-tight text-[#f4f1ea]">
                                        Planos
                                    </h2>
                                    <p className="mt-4 text-lg text-[#93a6a8]">
                                        Escolha o plano ideal e comece a
                                        permutar agora.
                                    </p>
                                </div>

                                <div className="mx-auto mt-16 grid max-w-4xl gap-6 sm:grid-cols-2">
                                    <PlanCardFree />
                                    <PlanCardYearly />
                                </div>
                            </div>
                        </section>
                    )}
                </main>

                <footer className="flex-none border-t border-[#1c2e30]">
                    <div className="mx-auto max-w-[920px] px-6 py-12">
                        <div className="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <div className="flex items-center gap-2">
                                <span className="font-['Space_Grotesk'] text-sm font-bold text-[#f4f1ea]">
                                    Clubset
                                </span>
                            </div>
                            <p className="text-sm text-[#93a6a8]">
                                Portal do audiovisual · prospecção, permuta e
                                vitrine de equipamento
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}

function Capability({
    number,
    title,
    description,
}: {
    number: string;
    title: string;
    description: string;
}) {
    return (
        <div className="border-[#1c2e30] p-[26px_18px] max-sm:first:border-l-0 max-sm:[&:nth-child(3)]:border-l-0 sm:border-l sm:first:border-l-0 max-sm:border-b max-sm:last:border-b-0 lg:py-[26px]">
            <div className="font-['Space_Grotesk'] text-[12px] tracking-[.04em] text-[#3fd6c9]">
                {number}
            </div>
            <h3 className="mt-2.5 mb-1.5 font-['Space_Grotesk'] text-[16px] font-semibold">
                {title}
            </h3>
            <p className="text-[13.5px] leading-[1.5] text-[#93a6a8]">
                {description}
            </p>
        </div>
    );
}

const bevel = {
    topRight: 'polygon(0 0, calc(100% - 18px) 0, 100% 18px, 100% 100%, 0 100%)',
    topLeft: 'polygon(18px 0, 100% 0, 100% 100%, 0 100%, 0 18px)',
};

function BevelCard({
    plan,
    clip,
    featured,
}: {
    plan: {
        name: string;
        tag: string;
        price: string;
        period: string;
        features: string[];
    };
    clip: 'topRight' | 'topLeft';
    featured?: boolean;
}) {
    return (
        <div
            className={
                featured
                    ? 'rounded-md bg-[#f2a63d] p-[1.5px]'
                    : 'rounded-md bg-[#1c2e30] p-[1.5px]'
            }
            style={{ clipPath: bevel[clip] }}
        >
            <div
                className="flex h-full flex-col rounded-md bg-[#0a1517] p-8"
                style={{ clipPath: bevel[clip] }}
            >
                <div className="flex items-center justify-between">
                    <span className="font-['Space_Grotesk'] text-sm text-[#f4f1ea]">
                        {plan.name}
                    </span>
                    <span
                        className={`rounded px-2 py-0.5 font-['Space_Grotesk'] text-[10px] font-semibold tracking-widest ${
                            featured
                                ? 'bg-[#f2a63d] text-[#060b10]'
                                : 'bg-[#3fd6c9]/15 text-[#3fd6c9]'
                        }`}
                    >
                        {plan.tag}
                    </span>
                </div>

                <div className="mt-6 flex items-baseline gap-1">
                    <span className="font-['Space_Grotesk'] text-4xl font-semibold text-[#f4f1ea]">
                        {plan.price}
                    </span>
                    <span className="text-sm text-[#93a6a8]">{plan.period}</span>
                </div>

                <ul className="mt-8 flex-1 space-y-3">
                    {plan.features.map((feature) => (
                        <li
                            key={feature}
                            className="flex items-start gap-2 text-sm text-[#93a6a8]"
                        >
                            <span
                                className={
                                    featured
                                        ? 'mt-0.5 text-[#f2a63d]'
                                        : 'mt-0.5 text-[#3fd6c9]'
                                }
                            >
                                <svg
                                    className="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    strokeWidth={2}
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                            </span>
                            <span>{feature}</span>
                        </li>
                    ))}
                </ul>

                <Link
                    href={register()}
                    className={`mt-8 inline-flex items-center justify-center rounded-[3px] px-6 py-3 font-['Space_Grotesk'] text-sm font-semibold transition-opacity hover:opacity-90 ${
                        featured
                            ? 'bg-[#f2a63d] text-[#060b10]'
                            : 'border border-[#1c2e30] text-[#f4f1ea]'
                    }`}
                >
                    Começar grátis
                </Link>
            </div>
        </div>
    );
}

function PlanCardFree() {
    return (
        <BevelCard
            clip="topLeft"
            plan={{
                name: 'Gratuito',
                tag: 'FREE',
                price: 'R$ 0',
                period: '/mes',
                features: [
                    'Prospecção local de clientes',
                    'Permutas bilaterais',
                    'Vitrine de equipamento',
                    'Acesso à escola de negócios',
                ],
            }}
        />
    );
}

function PlanCardYearly() {
    return (
        <BevelCard
            clip="topRight"
            featured
            plan={{
                name: 'Anual',
                tag: 'POPULAR',
                price: 'R$ 299',
                period: '/ano',
                features: [
                    'Tudo do plano Gratuito',
                    'Permutas por créditos',
                    'Matches ilimitados',
                    'Suporte prioritário',
                    'Estatísticas de mercado',
                ],
            }}
        />
    );
}
