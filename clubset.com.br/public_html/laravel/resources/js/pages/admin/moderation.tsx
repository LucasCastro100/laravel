import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { moderation as moderationRoute } from '@/routes/admin';
import { moderate } from '@/routes/admin/moderation';
import { Form, Head, router } from '@inertiajs/react';
import {
    CheckCircle2,
    Clock,
    DollarSign,
    MapPin,
    Tag,
    User,
    XCircle,
} from 'lucide-react';

interface ModerationListing {
    id: number;
    title: string;
    description: string;
    category: string;
    intent: string;
    region: string;
    city: string;
    price: string;
    ownerName: string;
    ownerEmail: string;
    createdAt: string;
}

interface ModerationProps {
    listings: {
        data: ModerationListing[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
}

export default function Moderation({ listings }: ModerationProps) {
    return (
        <>
            <Head title="Moderacao" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <h1 className="text-lg font-semibold">Moderacao</h1>

                {listings.data.length === 0 ? (
                    <div className="flex items-center justify-center rounded-xl border border-sidebar-border/70 p-12 text-sm text-muted-foreground dark:border-sidebar-border">
                        Nenhum anúncio pendente de moderação.
                    </div>
                ) : (
                    <div className="grid gap-4 md:grid-cols-2">
                        {listings.data.map((listing) => (
                            <Card key={listing.id}>
                                <CardHeader className="flex flex-row items-start justify-between space-y-0">
                                    <CardTitle className="text-sm font-medium">
                                        {listing.title}
                                    </CardTitle>
                                    <Badge variant="secondary">
                                        <Clock className="size-3" /> Pendente
                                    </Badge>
                                </CardHeader>
                                <CardContent className="space-y-3 text-sm">
                                    <p className="text-muted-foreground line-clamp-2">
                                        {listing.description}
                                    </p>

                                    <div className="flex flex-wrap gap-2">
                                        <Badge variant="outline">
                                            <Tag className="size-3" />{' '}
                                            {listing.category}
                                        </Badge>
                                        <Badge variant="outline">
                                            {listing.intent}
                                        </Badge>
                                    </div>

                                    <div className="flex items-center gap-2 text-muted-foreground">
                                        <MapPin className="size-4" />
                                        <span>
                                            {listing.city}, {listing.region}
                                        </span>
                                    </div>

                                    <div className="flex items-center gap-2 text-muted-foreground">
                                        <DollarSign className="size-4" />
                                        <span className="font-medium text-foreground">
                                            {listing.price}
                                        </span>
                                    </div>

                                    <div className="flex items-center gap-2 text-muted-foreground">
                                        <User className="size-4" />
                                        <span>
                                            {listing.ownerName} (
                                            {listing.ownerEmail})
                                        </span>
                                    </div>

                                    <div className="text-xs text-muted-foreground">
                                        Criado {listing.createdAt}
                                    </div>

                                    <div className="flex gap-2 pt-2">
                                        <Form
                                            {...moderate.form(listing.id)}
                                            className="flex-1"
                                        >
                                            <input
                                                type="hidden"
                                                name="action"
                                                value="approve"
                                            />
                                            <Button
                                                type="submit"
                                                variant="default"
                                                size="sm"
                                                className="w-full"
                                            >
                                                <CheckCircle2 className="size-4" />
                                                Aprovar
                                            </Button>
                                        </Form>
                                        <Form
                                            {...moderate.form(listing.id)}
                                            className="flex-1"
                                        >
                                            <input
                                                type="hidden"
                                                name="action"
                                                value="reject"
                                            />
                                            <Button
                                                type="submit"
                                                variant="destructive"
                                                size="sm"
                                                className="w-full"
                                            >
                                                <XCircle className="size-4" />
                                                Recusar
                                            </Button>
                                        </Form>
                                    </div>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                )}

                {listings.last_page > 1 && (
                    <div className="flex items-center justify-center gap-2 pt-4">
                        {Array.from(
                            { length: listings.last_page },
                            (_, i) => i + 1,
                        ).map((page) => (
                            <Button
                                key={page}
                                variant={
                                    page === listings.current_page
                                        ? 'default'
                                        : 'outline'
                                }
                                size="sm"
                                onClick={() => {
                                    router.get(
                                        moderationRoute.url(),
                                        { page },
                                        { preserveState: true },
                                    );
                                }}
                            >
                                {page}
                            </Button>
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}

Moderation.layout = {
    breadcrumbs: [
        {
            title: 'Moderacao',
            href: moderationRoute(),
        },
    ],
};
