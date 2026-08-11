export type Plan = {
    slug: string;
    name: string;
    description: string | null;
    price: string;
    formattedPrice: string;
    currency: string;
    trialDays: number;
    features: string[];
    isFree: boolean;
};

export type SubscriptionInfo = {
    status: string;
    stripePrice: string | null;
    onTrial: boolean;
    active: boolean;
    canceled: boolean;
    onGracePeriod: boolean;
    hasIncompletePayment: boolean;
    trialEndsAt: string | null;
    endsAt: string | null;
    latestPaymentId: string | null;
};

export type AssinaturaPageProps = {
    currentPlan: Plan | null;
    plans: Plan[];
    subscription: SubscriptionInfo | null;
    blockedAt: string | null;
    paymentDueAt: string | null;
    paymentGraceDays: number;
};
