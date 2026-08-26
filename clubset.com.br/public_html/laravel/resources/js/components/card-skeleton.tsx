import { cn } from '@/lib/utils';

interface CardSkeletonProps {
    count?: number;
    variant?: 'listing' | 'service' | 'match' | 'user';
    className?: string;
}

function SkeletonPulse({ className }: { className?: string }) {
    return <div className={cn('animate-pulse rounded-md bg-muted', className)} />;
}

function ListingCardSkeleton() {
    return (
        <div className="rounded-xl border p-4 space-y-3">
            <SkeletonPulse className="aspect-video w-full rounded-md" />
            <SkeletonPulse className="h-4 w-3/4" />
            <div className="flex gap-1.5">
                <SkeletonPulse className="h-5 w-16 rounded-full" />
                <SkeletonPulse className="h-5 w-12 rounded-full" />
            </div>
            <SkeletonPulse className="h-4 w-20" />
            <div className="flex items-center justify-between">
                <SkeletonPulse className="h-3 w-24" />
                <SkeletonPulse className="h-3 w-16" />
            </div>
            <SkeletonPulse className="h-3 w-28" />
        </div>
    );
}

function ServiceCardSkeleton() {
    return (
        <div className="rounded-xl border p-4 space-y-3">
            <SkeletonPulse className="h-4 w-3/4" />
            <SkeletonPulse className="h-5 w-20 rounded-full" />
            <div className="space-y-2">
                <div className="flex justify-between">
                    <SkeletonPulse className="h-3 w-12" />
                    <SkeletonPulse className="h-3 w-20" />
                </div>
                <div className="flex justify-between">
                    <SkeletonPulse className="h-3 w-20" />
                    <SkeletonPulse className="h-3 w-24" />
                </div>
            </div>
            <div className="border-t pt-3 flex justify-between">
                <SkeletonPulse className="h-3 w-16" />
                <SkeletonPulse className="h-6 w-20" />
            </div>
        </div>
    );
}

function MatchCardSkeleton() {
    return (
        <div className="rounded-xl border p-4 space-y-3">
            <div className="flex items-center justify-between">
                <SkeletonPulse className="h-4 w-20" />
                <SkeletonPulse className="h-5 w-16 rounded-full" />
            </div>
            <SkeletonPulse className="h-3 w-40" />
            <SkeletonPulse className="h-3 w-32" />
            <div className="flex items-center gap-2">
                <SkeletonPulse className="h-4 w-24" />
                <SkeletonPulse className="h-3 w-20" />
            </div>
            <SkeletonPulse className="h-3 w-16" />
        </div>
    );
}

function UserCardSkeleton() {
    return (
        <div className="rounded-xl border p-4 space-y-3">
            <div>
                <SkeletonPulse className="h-4 w-32" />
                <SkeletonPulse className="h-3 w-20 mt-1" />
            </div>
            <div className="rounded-md bg-muted p-2.5 space-y-1.5">
                <SkeletonPulse className="h-3 w-3/4" />
                <SkeletonPulse className="h-4 w-16 rounded-full" />
            </div>
            <SkeletonPulse className="h-8 w-full" />
        </div>
    );
}

const variants = {
    listing: ListingCardSkeleton,
    service: ServiceCardSkeleton,
    match: MatchCardSkeleton,
    user: UserCardSkeleton,
};

export function CardSkeleton({ count = 6, variant = 'listing', className }: CardSkeletonProps) {
    const Component = variants[variant];

    return (
        <div className={cn('grid gap-4 md:grid-cols-2 lg:grid-cols-3', className)}>
            {Array.from({ length: count }).map((_, i) => (
                <Component key={i} />
            ))}
        </div>
    );
}
