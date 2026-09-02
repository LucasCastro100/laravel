import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import {
    edit as listingsEdit,
    index as listingsIndex,
    show as listingsShow,
} from '@/routes/listings';
import { Head, Link, router } from '@inertiajs/react';
import {
    AlertTriangle,
    ArrowUpDown,
    Calendar,
    ChevronLeft,
    ChevronRight,
    Info,
    MapPin,
    MessageSquare,
    Pencil,
    Shield,
    Tag,
    Trash2,
    User,
} from 'lucide-react';
import { useState } from 'react';

type ListingOwner = {
    id: number;
    name: string;
    region: string | null;
    city: string | null;
};

type ListingData = {
    id: number;
    title: string;
    description: string;
    category: string;
    condition: string | null;
    intent: string;
    type: string;
    price: string;
    region: string | null;
    city: string | null;
    status: string;
    statusCode: string;
    moderationReason: string | null;
    owner: ListingOwner;
    images: { id: number; url: string; sort_order: number }[];
    createdAt: string;
};

type ExistingMatch = {
    id: number;
    status: string;
    statusLabel: string;
} | null;

type Option = { value: string; label: string };

type Props = {
    listing: ListingData;
    isOwner: boolean;
    canModerate: boolean;
    existingMatch: ExistingMatch;
    tradeTypes: Option[];
    conditions: Option[];
};

const statusVariant: Record<
    string,
    'default' | 'secondary' | 'destructive' | 'outline'
> = {
    active: 'default',
    pending: 'secondary',
    rejected: 'destructive',
    paused: 'outline',
};

export default function ListingsShow({
    listing,
    isOwner,
    canModerate,
    existingMatch,
}: Props) {
    const [currentImage, setCurrentImage] = useState(0);
    const images = listing.images ?? [];

    const handleDelete = () => {
        if (confirm('Tem certeza que deseja excluir este anúncio?')) {
            router.delete(listingsShow({ listing: listing.id }).url);
        }
    };

    return (
        <>
            <Head title={listing.title} />

            <div className="flex flex-col space-y-6">
                <div className="flex items-center justify-between">
                    <Heading variant="small" title={listing.title} />
                    <div className="flex items-center gap-2">
                        {isOwner && (
                            <>
                                <Button variant="outline" size="sm" asChild>
                                    <Link
                                        href={
                                            listingsEdit({
                                                listing: listing.id,
                                            }).url
                                        }
                                    >
                                        <Pencil className="size-4" />
                                        Editar
                                    </Link>
                                </Button>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    onClick={handleDelete}
                                >
                                    <Trash2 className="size-4" />
                                    Excluir
                                </Button>
                            </>
                        )}
                    </div>
                </div>

                {listing.moderationReason && (
                    <div className="flex items-start gap-2 rounded-lg border border-destructive/50 bg-destructive/10 p-4 text-sm">
                        <AlertTriangle className="mt-0.5 size-4 shrink-0 text-destructive" />
                        <div>
                            <p className="font-medium text-destructive">
                                Motivo da rejeição
                            </p>
                            <p className="text-muted-foreground">
                                {listing.moderationReason}
                            </p>
                        </div>
                    </div>
                )}

                <div className="grid gap-6 md:grid-cols-3">
                    <div className="space-y-6 md:col-span-2">
                        {images.length > 0 && (
                            <Card>
                                <CardContent className="p-2">
                                    <div className="relative">
                                        <div className="aspect-video overflow-hidden rounded-md">
                                            <img
                                                src={images[currentImage].url}
                                                alt={`${listing.title} ${currentImage + 1}`}
                                                className="size-full object-cover"
                                            />
                                            {currentImage === 0 && (
                                                <span className="absolute top-2 left-2 rounded bg-primary px-2 py-0.5 text-xs font-medium text-primary-foreground">
                                                    Capa
                                                </span>
                                            )}
                                        </div>

                                        {images.length > 1 && (
                                            <>
                                                <Button
                                                    variant="secondary"
                                                    size="icon"
                                                    className="absolute left-2 top-1/2 size-8 -translate-y-1/2 rounded-full bg-background/80 backdrop-blur-sm"
                                                    onClick={() =>
                                                        setCurrentImage(
                                                            (prev) =>
                                                                prev === 0
                                                                    ? images.length -
                                                                      1
                                                                    : prev - 1,
                                                        )
                                                    }
                                                >
                                                    <ChevronLeft className="size-4" />
                                                </Button>
                                                <Button
                                                    variant="secondary"
                                                    size="icon"
                                                    className="absolute right-2 top-1/2 size-8 -translate-y-1/2 rounded-full bg-background/80 backdrop-blur-sm"
                                                    onClick={() =>
                                                        setCurrentImage(
                                                            (prev) =>
                                                                prev ===
                                                                images.length -
                                                                    1
                                                                    ? 0
                                                                    : prev + 1,
                                                        )
                                                    }
                                                >
                                                    <ChevronRight className="size-4" />
                                                </Button>
                                            </>
                                        )}

                                        {images.length > 1 && (
                                            <div className="absolute bottom-2 left-1/2 flex -translate-x-1/2 gap-1.5">
                                                {images.map((_, i) => (
                                                    <button
                                                        key={i}
                                                        type="button"
                                                        onClick={() =>
                                                            setCurrentImage(i)
                                                        }
                                                        className={`size-2 rounded-full transition-colors ${
                                                            i === currentImage
                                                                ? 'bg-primary'
                                                                : 'bg-background/60'
                                                        }`}
                                                    />
                                                ))}
                                            </div>
                                        )}
                                    </div>

                                    {images.length > 1 && (
                                        <div className="mt-2 flex gap-1.5 overflow-x-auto px-1 pb-1">
                                            {images.map((img, i) => (
                                                <button
                                                    key={img.id}
                                                    type="button"
                                                    onClick={() =>
                                                        setCurrentImage(i)
                                                    }
                                                    className={`relative size-14 shrink-0 overflow-hidden rounded-md border-2 transition-colors ${
                                                        i === currentImage
                                                            ? 'border-primary'
                                                            : 'border-transparent opacity-60 hover:opacity-100'
                                                    }`}
                                                >
                                                    <img
                                                        src={img.url}
                                                        alt=""
                                                        className="size-full object-cover"
                                                    />
                                                </button>
                                            ))}
                                        </div>
                                    )}
                                </CardContent>
                            </Card>
                        )}

                        <Card>
                            <CardHeader>
                                <CardTitle>Detalhes</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="flex flex-wrap gap-2">
                                    <Badge
                                        variant={
                                            statusVariant[listing.statusCode] ??
                                            'secondary'
                                        }
                                    >
                                        {listing.status}
                                    </Badge>
                                    <Badge variant="outline">
                                        <Tag className="mr-1 size-3" />
                                        {listing.category}
                                    </Badge>
                                    <Badge variant="outline">
                                        <ArrowUpDown className="mr-1 size-3" />
                                        {listing.intent}
                                    </Badge>
                                    <Badge variant="outline">
                                        {listing.type}
                                    </Badge>
                                    {listing.condition && (
                                        <Badge variant="outline">
                                            {listing.condition}
                                        </Badge>
                                    )}
                                </div>

                                <p className="text-sm leading-relaxed text-muted-foreground">
                                    {listing.description}
                                </p>

                                <div className="grid grid-cols-2 gap-4 text-sm">
                                    <div className="space-y-1">
                                        <span className="text-muted-foreground">
                                            Preço
                                        </span>
                                        <p className="font-medium">
                                            {listing.price}
                                        </p>
                                    </div>
                                    <div className="space-y-1">
                                        <span className="text-muted-foreground">
                                            Criado em
                                        </span>
                                        <p className="flex items-center gap-1 font-medium">
                                            <Calendar className="size-3.5" />
                                            {listing.createdAt}
                                        </p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {listing.city || listing.region ? (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Localização</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="flex items-center gap-2 text-sm">
                                        <MapPin className="size-4 text-muted-foreground" />
                                        {[listing.city, listing.region]
                                            .filter(Boolean)
                                            .join(', ')}
                                    </p>
                                </CardContent>
                            </Card>
                        ) : null}

                        <div className="flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm dark:border-amber-800 dark:bg-amber-950">
                            <Info className="mt-0.5 size-4 shrink-0 text-amber-600 dark:text-amber-400" />
                            <div className="space-y-1">
                                <p className="font-medium text-amber-800 dark:text-amber-200">
                                    Negociação e pagamento fora da plataforma
                                </p>
                                <p className="text-amber-700 dark:text-amber-300">
                                    O ClubSet conecta compradores e vendedores,
                                    mas não intermedia pagamentos. Toda
                                    negociação, acordos e transações financeiras
                                    devem ser realizados diretamente entre as
                                    partes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Anunciante</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                <div className="flex items-center gap-3">
                                    <div className="flex size-9 items-center justify-center rounded-full bg-secondary">
                                        <User className="size-4 text-muted-foreground" />
                                    </div>
                                    <div>
                                        <p className="text-sm font-medium">
                                            {listing.owner.name}
                                        </p>
                                        {(listing.owner.city ||
                                            listing.owner.region) && (
                                            <p className="text-xs text-muted-foreground">
                                                {[
                                                    listing.owner.city,
                                                    listing.owner.region,
                                                ]
                                                    .filter(Boolean)
                                                    .join(', ')}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                {!isOwner &&
                                    listing.statusCode === 'active' && (
                                        <>
                                            <Separator />
                                            {existingMatch ? (
                                                <Badge
                                                    variant="secondary"
                                                    className="w-full justify-center"
                                                >
                                                    {existingMatch.statusLabel}
                                                </Badge>
                                            ) : (
                                                <Button
                                                    className="w-full"
                                                    size="sm"
                                                >
                                                    <MessageSquare className="size-4" />
                                                    Tenho interesse
                                                </Button>
                                            )}
                                        </>
                                    )}

                                {canModerate && (
                                    <>
                                        <Separator />
                                        <div className="flex gap-2">
                                            <Button
                                                variant="outline"
                                                size="sm"
                                                className="flex-1"
                                            >
                                                <Shield className="size-4" />
                                                Moderar
                                            </Button>
                                        </div>
                                    </>
                                )}
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </>
    );
}

ListingsShow.layout = {
    breadcrumbs: [
        { title: 'Anúncios', href: listingsIndex().url },
        { title: 'Detalhes', href: '#' },
    ],
};
