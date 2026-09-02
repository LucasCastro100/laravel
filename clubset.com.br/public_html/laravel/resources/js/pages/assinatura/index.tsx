import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    index as assinaturaIndex,
    cancel as cancelSubscription,
    checkout,
    resume as resumeSubscription,
} from '@/routes/assinatura';
import { payment as confirmPayment } from '@/routes/cashier';
import type {
    AssinaturaPageProps,
    Plan,
    SubscriptionInfo,
} from '@/types/billing';
import { Form, Head } from '@inertiajs/react';
import { Check, CreditCard } from 'lucide-react';

function statusLabel(subscription: SubscriptionInfo | null): string {
    if (!subscription) {
        return 'Trial';
    }

    if (subscription.onGracePeriod && subscription.canceled) {
        return 'Cancelada (ativa até o fim do período)';
    }

    if (subscription.canceled) {
        return 'Cancelada';
    }

    if (
        subscription.status === 'past_due' ||
        subscription.status === 'unpaid'
    ) {
        return 'Pagamento pendente';
    }

    if (subscription.hasIncompletePayment) {
        return 'Pagamento pendente';
    }

    if (subscription.onTrial) {
        return 'Em período de teste';
    }

    return 'Ativo';
}

export default function Assinatura({
    currentPlan,
    plans,
    subscription,
    blockedAt,
    paymentDueAt,
    paymentGraceDays,
}: AssinaturaPageProps) {
    const status = statusLabel(subscription);

    return (
        <>
            <Head title="Assinatura" />

            <div className="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4 md:p-6">
                {blockedAt && (
                    <div className="flex flex-col gap-2 rounded-xl border border-destructive/50 bg-destructive/10 p-4 text-sm text-destructive">
                        <p className="font-medium">
                            Sua conta está bloqueada por inadimplência.
                        </p>
                        <p>
                            Regularize o pagamento para voltar a usar a
                            plataforma. Sua assinatura fica bloqueada após{' '}
                            {paymentGraceDays} dias de atraso.
                        </p>
                    </div>
                )}

                <Heading
                    variant="small"
                    title="Assinatura"
                    description="Gerencie seu plano e pagamentos recorrentes"
                />

                {subscription && (
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                Plano atual: {currentPlan?.name ?? 'Trial'}
                                <Badge
                                    variant={
                                        blockedAt ? 'destructive' : 'secondary'
                                    }
                                >
                                    {status}
                                </Badge>
                            </CardTitle>
                            <CardDescription>
                                {currentPlan?.description}
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-3 text-sm">
                            <div className="flex items-center justify-between">
                                <span className="text-neutral-500">
                                    Valor mensal
                                </span>
                                <span className="font-medium">
                                    {currentPlan?.formattedPrice ?? 'R$ 0,00'}
                                </span>
                            </div>

                            {subscription.onTrial &&
                                subscription.trialEndsAt && (
                                    <div className="flex items-center justify-between">
                                        <span className="text-neutral-500">
                                            Fim do período de teste
                                        </span>
                                        <span className="font-medium">
                                            {new Date(
                                                subscription.trialEndsAt,
                                            ).toLocaleDateString('pt-BR')}
                                        </span>
                                    </div>
                                )}

                            {subscription.onGracePeriod &&
                                subscription.endsAt && (
                                    <div className="flex items-center justify-between">
                                        <span className="text-neutral-500">
                                            Ativo até
                                        </span>
                                        <span className="font-medium">
                                            {new Date(
                                                subscription.endsAt,
                                            ).toLocaleDateString('pt-BR')}
                                        </span>
                                    </div>
                                )}

                            {paymentDueAt && !blockedAt && (
                                <div className="flex items-center justify-between text-destructive">
                                    <span className="text-neutral-500">
                                        Pagamento devido desde
                                    </span>
                                    <span className="font-medium">
                                        {new Date(
                                            paymentDueAt,
                                        ).toLocaleDateString('pt-BR')}
                                    </span>
                                </div>
                            )}

                            {subscription.hasIncompletePayment &&
                                subscription.latestPaymentId && (
                                    <div className="flex items-center justify-between">
                                        <span className="text-neutral-500">
                                            Cobrança pendente de confirmação
                                        </span>
                                        <Button
                                            asChild
                                            variant="outline"
                                            size="sm"
                                        >
                                            <a
                                                href={confirmPayment.url(
                                                    subscription.latestPaymentId,
                                                )}
                                            >
                                                <CreditCard />
                                                Confirmar pagamento
                                            </a>
                                        </Button>
                                    </div>
                                )}
                        </CardContent>
                        {!subscription.onTrial && subscription.active && (
                            <CardFooter className="justify-end gap-2">
                                {subscription.canceled ? (
                                    subscription.onGracePeriod && (
                                        <Form {...resumeSubscription.form()}>
                                            <Button
                                                type="submit"
                                                variant="secondary"
                                            >
                                                Reativar assinatura
                                            </Button>
                                        </Form>
                                    )
                                ) : (
                                    <Form {...cancelSubscription.form()}>
                                        <Button type="submit" variant="outline">
                                            Cancelar assinatura
                                        </Button>
                                    </Form>
                                )}
                            </CardFooter>
                        )}
                    </Card>
                )}

                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    {plans.map((plan) => (
                        <PlanCard
                            key={plan.slug}
                            plan={plan}
                            isCurrent={plan.slug === currentPlan?.slug}
                            hasSubscription={Boolean(subscription)}
                        />
                    ))}
                </div>
            </div>
        </>
    );
}

function PlanCard({
    plan,
    isCurrent,
    hasSubscription,
}: {
    plan: Plan;
    isCurrent: boolean;
    hasSubscription: boolean;
}) {
    const cta = (() => {
        if (isCurrent) {
            return (
                <Button disabled className="w-full">
                    Plano atual
                </Button>
            );
        }

        if (plan.isFree) {
            if (!hasSubscription) {
                return (
                    <Button disabled className="w-full">
                        Plano atual
                    </Button>
                );
            }

            return (
                <Form {...cancelSubscription.form()}>
                    <Button type="submit" variant="outline" className="w-full">
                        Cancelar e voltar ao Trial
                    </Button>
                </Form>
            );
        }

        return (
            <Form {...checkout.form(plan.slug)}>
                <Button type="submit" className="w-full">
                    Assinar
                </Button>
            </Form>
        );
    })();

    return (
        <Card className="flex flex-col">
            <CardHeader>
                <CardTitle>{plan.name}</CardTitle>
                <CardDescription>{plan.description}</CardDescription>
                <div className="mt-2 flex items-baseline gap-1">
                    <span className="text-3xl font-semibold">
                        {plan.formattedPrice}
                    </span>
                    <span className="text-sm text-neutral-500">/mês</span>
                </div>
                {plan.trialDays > 0 && (
                    <p className="text-xs text-neutral-500">
                        {plan.trialDays} dias grátis para experimentar
                    </p>
                )}
            </CardHeader>
            <CardContent className="flex-1">
                <ul className="space-y-2 text-sm">
                    {plan.features.map((feature) => (
                        <li
                            key={feature}
                            className="flex items-start gap-2 text-neutral-600 dark:text-neutral-300"
                        >
                            <Check className="mt-0.5 size-4 shrink-0 text-primary" />
                            <span>{feature}</span>
                        </li>
                    ))}
                </ul>
            </CardContent>
            <CardFooter>{cta}</CardFooter>
        </Card>
    );
}

Assinatura.layout = {
    breadcrumbs: [
        {
            title: 'Assinatura',
            href: assinaturaIndex(),
        },
    ],
};
