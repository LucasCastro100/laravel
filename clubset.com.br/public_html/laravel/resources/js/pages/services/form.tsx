import { Form, Head } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { ArrowLeft } from 'lucide-react';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { MoneyInput } from '@/components/ui/money-input';
import { SearchSelect } from '@/components/ui/search-select';
import {
    create as serviceCreate,
    edit as serviceEdit,
    index as servicesIndex,
    update as serviceUpdate,
} from '@/routes/services';

type Service = {
    id: number;
    title: string;
    description: string;
    specialty: string;
    rate: string;
    rateType: string;
    stateId: number | string;
    municipalityId: number | string;
};

type Option = { value: string; label: string };
type StateOption = { id: number; name: string; uf: string; region: string };
type MunicipalityOption = { id: number; name: string };

type Props = {
    service: Service | null;
    rateTypes: Option[];
    specialties: string[];
    regions: string[];
    states: StateOption[];
    municipalities: MunicipalityOption[];
    defaultStateId: number | string;
    defaultMunicipalityId: number | string;
};

export default function ServiceForm({
    service,
    rateTypes,
    specialties,
    regions,
    states,
    municipalities: initialMunicipalities,
    defaultStateId,
    defaultMunicipalityId,
}: Props) {
    const isEditing = Boolean(service);
    const defaultState = states.find((s) => s.id.toString() === String(defaultStateId));
    const [selectedRegion, setSelectedRegion] = useState(defaultState?.region ?? '');
    const [municipalities, setMunicipalities] = useState<MunicipalityOption[]>(initialMunicipalities);
    const [loadingMunicipalities, setLoadingMunicipalities] = useState(false);

    const filteredStates = selectedRegion
        ? states.filter((s) => s.region === selectedRegion)
        : states;

    const stateOptions = filteredStates.map((s) => ({
        value: s.id.toString(),
        label: `${s.uf} - ${s.name}`,
    }));

    const municipalityOptions = municipalities.map((m) => ({
        value: m.id.toString(),
        label: m.name,
    }));

    const specialtyOptions = specialties.map((s) => ({
        value: s,
        label: s,
    }));

    useEffect(() => {
        const stateId = String(service?.stateId ?? defaultStateId ?? '');
        if (!stateId) return;
        setLoadingMunicipalities(true);
        fetch(`/municipalities?state_id=${stateId}`)
            .then((res) => res.json())
            .then((json: MunicipalityOption[]) => {
                setMunicipalities(json);
                setLoadingMunicipalities(false);
            })
            .catch(() => setLoadingMunicipalities(false));
    }, []);

    const fetchMunicipalities = (stateId: string) => {
        if (!stateId) {
            setMunicipalities([]);
            return;
        }
        setLoadingMunicipalities(true);
        fetch(`/municipalities?state_id=${stateId}`)
            .then((res) => res.json())
            .then((json: MunicipalityOption[]) => {
                setMunicipalities(json);
                setLoadingMunicipalities(false);
            })
            .catch(() => setLoadingMunicipalities(false));
    };

    return (
        <>
            <Head title={isEditing ? 'Editar serviço' : 'Novo serviço'} />

            <div className="flex flex-col space-y-4">
                <div className="flex items-center gap-3">
                    <Button variant="ghost" size="sm" asChild>
                        <a href={servicesIndex().url}>
                            <ArrowLeft className="size-4" />
                        </a>
                    </Button>
                            <Heading
                                variant="small"
                                title={isEditing ? 'Editar serviço' : 'Novo serviço'}
                                description={isEditing ? 'Atualize as informações do serviço' : 'Preencha os dados para criar um novo serviço'}
                    />
                </div>

                <Form
                    method={isEditing ? 'put' : 'post'}
                    action={
                        isEditing
                            ? serviceUpdate({ service: service!.id }).url
                            : serviceCreate().url
                    }
                    className="space-y-4"
                >
                    {({ errors, processing }) => (
                        <>
                            <Card>
                                <CardHeader className="py-3">
                                    <CardTitle className="text-base">Informações básicas</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    <div className="grid gap-3 sm:grid-cols-2">
                                        <div className="grid gap-2">
                                            <Label htmlFor="title">Título</Label>
                                            <Input
                                                id="title"
                                                name="title"
                                                defaultValue={service?.title ?? ''}
                                                placeholder="Ex: Aula de violão"
                                                required
                                            />
                                            <InputError message={errors.title} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label>Especialidade</Label>
                                            <SearchSelect
                                                options={specialtyOptions}
                                                defaultValue={service?.specialty ?? ''}
                                                name="specialty"
                                                placeholder="Selecione a especialidade"
                                                title="Especialidade"
                                            />
                                            <InputError message={errors.specialty} />
                                        </div>
                                    </div>

                                    <div className="grid gap-2">
                                        <Label htmlFor="description">Descrição</Label>
                                        <textarea
                                            id="description"
                                            name="description"
                                            rows={3}
                                            defaultValue={service?.description ?? ''}
                                            placeholder="Descreva o serviço oferecido..."
                                            className="flex w-full min-w-0 rounded-md border bg-transparent px-3 py-2 text-base shadow-xs outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] md:text-sm"
                                        />
                                        <InputError message={errors.description} />
                                    </div>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="py-3">
                                    <CardTitle className="text-base">Valor</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className="grid gap-3 sm:grid-cols-2">
                                        <div className="grid gap-2">
                                            <Label htmlFor="rate">Valor (R$)</Label>
                                            <MoneyInput
                                                id="rate"
                                                name="rate"
                                                defaultValue={service?.rate ?? ''}
                                            />
                                            <InputError message={errors.rate} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label>Tipo de valor</Label>
                                            <SearchSelect
                                                options={rateTypes}
                                                defaultValue={service?.rateType ?? ''}
                                                name="rateType"
                                                placeholder="Selecione o tipo"
                                                title="Tipo de valor"
                                            />
                                            <InputError message={errors.rateType} />
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="py-3">
                                    <CardTitle className="text-base">Localização</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className="grid gap-3 sm:grid-cols-3">
                                        <div className="grid gap-2">
                                            <Label>Região</Label>
                                            <SearchSelect
                                                options={regions.map((r) => ({ value: r, label: r }))}
                                                value={selectedRegion}
                                                onValueChange={(v) => {
                                                    setSelectedRegion(v);
                                                }}
                                                placeholder="Selecione a região"
                                                title="Região"
                                                clearable
                                            />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label>Estado</Label>
                                            <SearchSelect
                                                options={stateOptions}
                                                defaultValue={String(service?.stateId ?? defaultStateId ?? '')}
                                                name="stateId"
                                                onValueChange={(v) => fetchMunicipalities(v)}
                                                placeholder={selectedRegion ? 'Selecione o estado' : 'Selecione a região primeiro'}
                                                disabled={!selectedRegion}
                                                title="Estado"
                                            />
                                            <InputError message={errors.stateId} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label>Município</Label>
                                            <SearchSelect
                                                options={municipalityOptions}
                                                defaultValue={String(service?.municipalityId ?? defaultMunicipalityId ?? '')}
                                                name="municipalityId"
                                                placeholder={!String(service?.stateId ?? defaultStateId ?? '') ? 'Selecione o estado primeiro' : loadingMunicipalities ? 'Carregando...' : 'Selecione o município'}
                                                disabled={!String(service?.stateId ?? defaultStateId ?? '') || loadingMunicipalities}
                                                title="Município"
                                                clearable
                                            />
                                            <InputError message={errors.municipalityId} />
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>

                            <div className="flex items-center justify-end gap-3">
                                <Button variant="outline" type="button" asChild>
                                    <a href={servicesIndex().url}>Cancelar</a>
                                </Button>
                                <Button type="submit" disabled={processing}>
                                    {isEditing ? 'Salvar' : 'Criar serviço'}
                                </Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}

ServiceForm.layout = (
    props: { service: { id: number; title: string } } | {},
) => {
    const service = 'service' in props ? props.service : null;

    return {
        breadcrumbs: [
            {
                title: 'Serviços',
                href: servicesIndex(),
            },
            {
                title: service ? 'Editar serviço' : 'Novo serviço',
                href: service
                    ? serviceEdit({ service: service.id })
                    : serviceCreate(),
            },
        ],
    };
};
