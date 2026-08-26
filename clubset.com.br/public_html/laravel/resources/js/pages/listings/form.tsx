import { Head, router, useForm, usePage } from '@inertiajs/react';
import { useCallback, useState, useEffect, useRef } from 'react';
import { Save, X, Upload, Trash2, ChevronLeft, ChevronRight } from 'lucide-react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { MoneyInput } from '@/components/ui/money-input';
import { SearchSelect } from '@/components/ui/search-select';
import { index as listingsIndex, store as listingsStore, update as listingsUpdate } from '@/routes/listings';

type ListingData = {
    id: number;
    title: string;
    description: string;
    category: string;
    condition: string | null;
    intent: string;
    type: string;
    price: string | number;
    state_id: number | null;
    municipality_id: number | null;
    images?: { id: number; url: string; sort_order: number }[];
};

type Option = { value: string; label: string };
type StateOption = { id: number; name: string; uf: string; region: string };
type MunicipalityOption = { id: number; name: string };

type Props = {
    listing: ListingData | null;
    categories: Option[];
    conditions: Option[];
    intents: Option[];
    types: Option[];
    regions: string[];
    states: StateOption[];
    municipalities: MunicipalityOption[];
    defaultStateId: number | null;
    defaultMunicipalityId: number | null;
};

export default function ListingsForm({
    listing,
    categories,
    conditions,
    intents,
    types,
    regions,
    states,
    municipalities: initialMunicipalities,
    defaultStateId,
    defaultMunicipalityId,
}: Props) {
    const isEditing = !!listing;
    const defaultState = states.find((s) => s.id.toString() === (defaultStateId?.toString() ?? ''));
    const [selectedRegion, setSelectedRegion] = useState(defaultState?.region ?? '');
    const [municipalities, setMunicipalities] = useState<MunicipalityOption[]>(initialMunicipalities);
    const [loadingMunicipalities, setLoadingMunicipalities] = useState(false);
    const [dragActive, setDragActive] = useState(false);
    const [imageFiles, setImageFiles] = useState<File[]>([]);
    const [imagePreviews, setImagePreviews] = useState<string[]>([]);
    const [removedImageIds, setRemovedImageIds] = useState<number[]>([]);
    const fileInputRef = useRef<HTMLInputElement>(null);
    const { maxImagesPerListing } = usePage().props as { maxImagesPerListing?: number };
    const maxImages = maxImagesPerListing ?? 6;

    const { data, setData, post, put, processing, errors } = useForm({
        title: listing?.title ?? '',
        description: listing?.description ?? '',
        category: listing?.category ?? '',
        condition: listing?.condition ?? '',
        intent: listing?.intent ?? '',
        type: listing?.type ?? '',
        price: listing?.price ?? '',
        state_id: listing?.state_id?.toString() ?? defaultStateId?.toString() ?? '',
        municipality_id: listing?.municipality_id?.toString() ?? defaultMunicipalityId?.toString() ?? '',
    });

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

    useEffect(() => {
        if (!data.state_id) {
            setMunicipalities([]);
            return;
        }
        setLoadingMunicipalities(true);
        fetch(`/municipalities?state_id=${data.state_id}`)
            .then((res) => res.json())
            .then((json: MunicipalityOption[]) => {
                setMunicipalities(json);
                setLoadingMunicipalities(false);
            })
            .catch(() => setLoadingMunicipalities(false));
    }, [data.state_id]);

    const existingImages = (listing?.images ?? []).filter((img) => !removedImageIds.includes(img.id));
    const totalImages = existingImages.length + imageFiles.length;

    const handleFiles = useCallback((files: FileList | File[]) => {
        const arr = Array.from(files).filter((f) => f.type.startsWith('image/'));
        const remaining = maxImages - totalImages;
        const toAdd = arr.slice(0, remaining);
        setImageFiles((prev) => [...prev, ...toAdd]);
        toAdd.forEach((file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                setImagePreviews((prev) => [...prev, e.target?.result as string]);
            };
            reader.readAsDataURL(file);
        });
    }, [totalImages, maxImages]);

    const removeImage = useCallback((index: number) => {
        setImageFiles((prev) => prev.filter((_, i) => i !== index));
        setImagePreviews((prev) => prev.filter((_, i) => i !== index));
    }, []);

    const removeExistingImage = useCallback((id: number) => {
        setRemovedImageIds((prev) => [...prev, id]);
    }, []);

    const moveImage = useCallback((from: number, to: number) => {
        if (to < 0 || to >= imageFiles.length) return;
        setImageFiles((prev) => {
            const arr = [...prev];
            const [item] = arr.splice(from, 1);
            arr.splice(to, 0, item);
            return arr;
        });
        setImagePreviews((prev) => {
            const arr = [...prev];
            const [item] = arr.splice(from, 1);
            arr.splice(to, 0, item);
            return arr;
        });
    }, [imageFiles.length]);

    const handleDrag = useCallback((e: React.DragEvent) => {
        e.preventDefault();
        e.stopPropagation();
        if (e.type === 'dragenter' || e.type === 'dragover') setDragActive(true);
        else if (e.type === 'dragleave') setDragActive(false);
    }, []);

    const handleDrop = useCallback((e: React.DragEvent) => {
        e.preventDefault();
        e.stopPropagation();
        setDragActive(false);
        if (e.dataTransfer.files) handleFiles(e.dataTransfer.files);
    }, [handleFiles]);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        const formData = new FormData();
        Object.entries(data).forEach(([key, value]) => {
            if (value !== null && value !== undefined && value !== '') {
                formData.append(key, String(value));
            }
        });
        imageFiles.forEach((file) => {
            formData.append('images[]', file);
        });

        if (isEditing) {
            formData.append('_method', 'PUT');
            removedImageIds.forEach((id) => formData.append('removed_images[]', String(id)));
            router.post(listingsUpdate({ listing: listing.id }).url, formData, {
                preserveScroll: true,
                forceFormData: true,
            });
        } else {
            router.post(listingsStore().url, formData, {
                preserveScroll: true,
                forceFormData: true,
            });
        }
    };

    return (
        <>
            <Head title={isEditing ? 'Editar anúncio' : 'Novo anúncio'} />

            <div className="flex flex-col space-y-4">
                <Heading
                    variant="small"
                    title={isEditing ? 'Editar anúncio' : 'Novo anúncio'}
                    description={isEditing ? 'Atualize as informações do seu anúncio' : 'Preencha os dados para criar um novo anúncio'}
                />

                <form onSubmit={handleSubmit} className="space-y-4" encType="multipart/form-data">
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
                                        value={data.title}
                                        onChange={(e) => setData('title', e.target.value)}
                                        placeholder="Ex: Driver Titleist TSR3 9°"
                                    />
                                    {errors.title && <p className="text-xs text-destructive">{errors.title}</p>}
                                </div>

                                <div className="grid gap-2">
                                    <Label>Categoria</Label>
                                    <SearchSelect
                                        options={categories}
                                        value={data.category}
                                        onValueChange={(v) => setData('category', v)}
                                        placeholder="Selecione a categoria"
                                        title="Categoria"
                                    />
                                    {errors.category && <p className="text-xs text-destructive">{errors.category}</p>}
                                </div>
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="description">Descrição</Label>
                                <textarea
                                    id="description"
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    rows={3}
                                    className="flex w-full min-w-0 rounded-md border bg-transparent px-3 py-2 text-base shadow-xs outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] md:text-sm"
                                    placeholder="Descreva o equipamento, estado de conservação, etc."
                                />
                                {errors.description && <p className="text-xs text-destructive">{errors.description}</p>}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="py-3">
                            <CardTitle className="text-base">Fotos</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            <p className="text-xs text-muted-foreground">
                                Máximo <strong>{maxImages}</strong> fotos · A primeira foto será a capa do anúncio · Arraste para reordenar · JPG, PNG ou WebP
                            </p>

                            <div
                                className={`relative flex flex-col items-center justify-center rounded-lg border-2 border-dashed p-6 transition-colors cursor-pointer ${
                                    dragActive
                                        ? 'border-primary bg-primary/5'
                                        : imageFiles.length >= maxImages
                                            ? 'border-muted-foreground/10 opacity-50 cursor-not-allowed'
                                            : 'border-muted-foreground/25 hover:border-muted-foreground/50'
                                }`}
                                onDragEnter={handleDrag}
                                onDragLeave={handleDrag}
                                onDragOver={handleDrag}
                                onDrop={handleDrop}
                                onClick={() => {
                                    if (imageFiles.length < maxImages) fileInputRef.current?.click();
                                }}
                            >
                                <input
                                    ref={fileInputRef}
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    className="hidden"
                                    onChange={(e) => {
                                        if (e.target.files) handleFiles(e.target.files);
                                        e.target.value = '';
                                    }}
                                />
                                <Upload className="mb-2 size-8 text-muted-foreground" />
                                <p className="text-sm text-muted-foreground">
                                    {totalImages >= maxImages
                                        ? `Limite de ${maxImages} fotos atingido`
                                        : <>Arraste imagens aqui ou <span className="text-primary underline">clique para selecionar</span></>
                                    }
                                </p>
                                <p className="mt-1 text-xs text-muted-foreground">
                                    {totalImages} / {maxImages} fotos
                                </p>
                            </div>

                            {(existingImages.length > 0 || imagePreviews.length > 0) && (
                                <div className="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-6">
                                    {existingImages.map((img, index) => (
                                        <div key={img.id} className="group relative aspect-square overflow-hidden rounded-md border">
                                            <img src={img.url} alt="" className="size-full object-cover" />
                                            <div className="absolute top-1 left-1 flex gap-1">
                                                {index === 0 && imagePreviews.length === 0 && (
                                                    <span className="rounded bg-primary px-1.5 py-0.5 text-[10px] font-medium text-primary-foreground">
                                                        Capa
                                                    </span>
                                                )}
                                            </div>
                                            <div className="absolute top-1 right-1 opacity-0 transition-opacity group-hover:opacity-100">
                                                <button
                                                    type="button"
                                                    onClick={() => removeExistingImage(img.id)}
                                                    className="rounded-full bg-black/60 p-1 text-white hover:bg-red-600"
                                                    title="Remover"
                                                >
                                                    <Trash2 className="size-3" />
                                                </button>
                                            </div>
                                        </div>
                                    ))}
                                    {imagePreviews.map((preview, index) => (
                                        <div key={`new-${index}`} className="group relative aspect-square overflow-hidden rounded-md border">
                                            <img src={preview} alt={`Nova foto ${index + 1}`} className="size-full object-cover" />
                                            <div className="absolute top-1 left-1 flex gap-1">
                                                {index === 0 && existingImages.length === 0 && (
                                                    <span className="rounded bg-primary px-1.5 py-0.5 text-[10px] font-medium text-primary-foreground">
                                                        Capa
                                                    </span>
                                                )}
                                                <span className="rounded bg-green-600 px-1 py-0.5 text-[10px] text-white">
                                                    Nova
                                                </span>
                                            </div>
                                            <div className="absolute top-1 right-1 flex gap-1 opacity-0 transition-opacity group-hover:opacity-100">
                                                {index > 0 && (
                                                    <button
                                                        type="button"
                                                        onClick={() => moveImage(index, index - 1)}
                                                        className="rounded-full bg-black/60 p-1 text-white hover:bg-black/80"
                                                        title="Mover para frente"
                                                    >
                                                        <ChevronLeft className="size-3" />
                                                    </button>
                                                )}
                                                {index < imageFiles.length - 1 && (
                                                    <button
                                                        type="button"
                                                        onClick={() => moveImage(index, index + 1)}
                                                        className="rounded-full bg-black/60 p-1 text-white hover:bg-black/80"
                                                        title="Mover para trás"
                                                    >
                                                        <ChevronRight className="size-3" />
                                                    </button>
                                                )}
                                                <button
                                                    type="button"
                                                    onClick={() => removeImage(index)}
                                                    className="rounded-full bg-black/60 p-1 text-white hover:bg-red-600"
                                                    title="Remover"
                                                >
                                                    <Trash2 className="size-3" />
                                                </button>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="py-3">
                            <CardTitle className="text-base">Classificação</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            <div className="grid gap-3 sm:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label>Condição</Label>
                                    <SearchSelect
                                        options={conditions}
                                        value={data.condition ?? ''}
                                        onValueChange={(v) => setData('condition', v)}
                                        placeholder="Selecione a condição"
                                        title="Condição"
                                        clearable
                                    />
                                    {errors.condition && <p className="text-xs text-destructive">{errors.condition}</p>}
                                </div>

                                <div className="grid gap-2">
                                    <Label>Intenção</Label>
                                    <SearchSelect
                                        options={intents}
                                        value={data.intent}
                                        onValueChange={(v) => setData('intent', v)}
                                        placeholder="Selecione a intenção"
                                        title="Intenção"
                                    />
                                    {errors.intent && <p className="text-xs text-destructive">{errors.intent}</p>}
                                </div>
                            </div>

                            <div className="grid gap-3 sm:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label>Tipo de negócio</Label>
                                    <SearchSelect
                                        options={types}
                                        value={data.type}
                                        onValueChange={(v) => setData('type', v)}
                                        placeholder="Selecione o tipo"
                                        title="Tipo de negócio"
                                    />
                                    {errors.type && <p className="text-xs text-destructive">{errors.type}</p>}
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="price">Preço (R$)</Label>
                                    <MoneyInput
                                        id="price"
                                        value={String(data.price ?? '')}
                                        onChange={(v) => setData('price', v)}
                                    />
                                    {errors.price && <p className="text-xs text-destructive">{errors.price}</p>}
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
                                            setData('state_id', '');
                                            setData('municipality_id', '');
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
                                        value={data.state_id}
                                        onValueChange={(v) => {
                                            setData('state_id', v);
                                            setData('municipality_id', '');
                                        }}
                                        placeholder={selectedRegion ? 'Selecione o estado' : 'Selecione a região primeiro'}
                                        disabled={!selectedRegion}
                                        title="Estado"
                                    />
                                    {errors.state_id && <p className="text-xs text-destructive">{errors.state_id}</p>}
                                </div>

                                <div className="grid gap-2">
                                    <Label>Município</Label>
                                    <SearchSelect
                                        options={municipalityOptions}
                                        value={data.municipality_id}
                                        onValueChange={(v) => setData('municipality_id', v)}
                                        placeholder={!data.state_id ? 'Selecione o estado primeiro' : loadingMunicipalities ? 'Carregando...' : 'Selecione o município'}
                                        disabled={!data.state_id || loadingMunicipalities}
                                        title="Município"
                                        clearable
                                    />
                                    {errors.municipality_id && <p className="text-xs text-destructive">{errors.municipality_id}</p>}
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <div className="flex items-center justify-end gap-3">
                        <Button type="button" variant="ghost" onClick={() => router.get(listingsIndex().url)}>
                            <X className="size-4" />
                            Cancelar
                        </Button>
                        <Button type="submit" disabled={processing}>
                            <Save className="size-4" />
                            {isEditing ? 'Salvar alterações' : 'Publicar anúncio'}
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
}

ListingsForm.layout = {
    breadcrumbs: [
        { title: 'Anúncios', href: listingsIndex().url },
        { title: 'Formulário', href: '#' },
    ],
};
