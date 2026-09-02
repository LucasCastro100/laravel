import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import { edit as serviceEdit, index as servicesIndex } from '@/routes/services';
import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, MapPin, Pencil, Star, User } from 'lucide-react';

type TradeType = {
    id: number;
    name: string;
};

type Service = {
    id: number;
    title: string;
    description: string;
    specialty: string;
    rate: string;
    region: string;
    city: string;
    providerName: string;
    providerId: number;
    tradeTypes: TradeType[];
    createdAt: string;
};

type Props = {
    service: Service;
    isOwner: boolean;
    existingMatch: boolean;
    tradeTypes: TradeType[];
};

export default function ServiceShow({
    service,
    isOwner,
    existingMatch,
    tradeTypes,
}: Props) {
    return (
        <>
            <Head title={service.title} />

            <div className="flex flex-col space-y-6">
                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <Button variant="ghost" size="sm" asChild>
                            <Link href={servicesIndex().url}>
                                <ArrowLeft className="size-4" />
                            </Link>
                        </Button>
                        <Heading
                            variant="small"
                            title={service.title}
                            description="Detalhes do serviço"
                        />
                    </div>

                    {isOwner && (
                        <Button variant="outline" size="sm" asChild>
                            <Link href={serviceEdit({ service: service.id })}>
                                <Pencil className="size-4" />
                                Editar
                            </Link>
                        </Button>
                    )}
                </div>

                <div className="grid gap-6 md:grid-cols-3">
                    <div className="md:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <div className="flex items-start justify-between">
                                    <div>
                                        <CardTitle>{service.title}</CardTitle>
                                        <CardDescription className="mt-1">
                                            Publicado em{' '}
                                            {new Date(
                                                service.createdAt,
                                            ).toLocaleDateString('pt-BR')}
                                        </CardDescription>
                                    </div>
                                    <Badge variant="secondary">
                                        {service.specialty}
                                    </Badge>
                                </div>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <p className="text-sm text-muted-foreground whitespace-pre-wrap">
                                    {service.description}
                                </p>

                                <Separator />

                                <div className="grid gap-4 sm:grid-cols-2">
                                    <div className="space-y-1">
                                        <span className="text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                            Valor
                                        </span>
                                        <p className="text-lg font-semibold">
                                            {service.rate}
                                        </p>
                                    </div>
                                    <div className="space-y-1">
                                        <span className="text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                            Localização
                                        </span>
                                        <p className="flex items-center gap-1 text-lg font-semibold">
                                            <MapPin className="size-4 text-muted-foreground" />
                                            {service.city}, {service.region}
                                        </p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {tradeTypes.length > 0 && (
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-base">
                                        Tipos de permuta aceitos
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className="flex flex-wrap gap-2">
                                        {tradeTypes.map((type) => (
                                            <Badge
                                                key={type.id}
                                                variant="outline"
                                            >
                                                {type.name}
                                            </Badge>
                                        ))}
                                    </div>
                                </CardContent>
                            </Card>
                        )}
                    </div>

                    <div className="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-base">
                                    Prestador
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="flex items-center gap-3">
                                    <div className="flex size-10 items-center justify-center rounded-full bg-muted">
                                        <User className="size-5 text-muted-foreground" />
                                    </div>
                                    <div>
                                        <p className="font-medium">
                                            {service.providerName}
                                        </p>
                                        <p className="text-xs text-muted-foreground">
                                            Prestador
                                        </p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {!isOwner && (
                            <Card>
                                <CardContent className="pt-6">
                                    {existingMatch ? (
                                        <Button disabled className="w-full">
                                            <Star className="size-4" />
                                            Interesse ja registrado
                                        </Button>
                                    ) : (
                                        <Button className="w-full">
                                            <Star className="size-4" />
                                            Tenho interesse
                                        </Button>
                                    )}
                                </CardContent>
                            </Card>
                        )}
                    </div>
                </div>
            </div>
        </>
    );
}

ServiceShow.layout = (props: { service: { id: number; title: string } }) => ({
    breadcrumbs: [
        {
            title: 'Servicos',
            href: servicesIndex(),
        },
        {
            title: props.service.title,
            href: serviceShow({ service: props.service.id }),
        },
    ],
});
