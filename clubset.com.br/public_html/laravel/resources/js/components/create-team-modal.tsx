import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/react';
import type { PropsWithChildren } from 'react';
import { useState } from 'react';
// import { store } from '@/routes/teams';

export default function CreateTeamModal({ children }: PropsWithChildren) {
    const [open, setOpen] = useState(false);

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>{children}</DialogTrigger>
            <DialogContent>
                <Form
                    key={String(open)}
                    method="post"
                    action="#"
                    className="space-y-6"
                    onSuccess={() => setOpen(false)}
                >
                    {({ errors, processing }) => (
                        <>
                            <DialogHeader>
                                <DialogTitle>Criar uma nova equipe</DialogTitle>
                                <DialogDescription>
                                    Crie uma nova equipe para colaborar com
                                    outras pessoas.
                                </DialogDescription>
                            </DialogHeader>

                            <div className="grid gap-2">
                                <Label htmlFor="name">Nome da equipe</Label>
                                <Input
                                    id="name"
                                    name="name"
                                    data-test="create-team-name"
                                    placeholder="Minha equipe"
                                    required
                                />
                                <InputError message={errors.name} />
                            </div>

                            <DialogFooter className="gap-2">
                                <DialogClose asChild>
                                    <Button variant="secondary">
                                        Cancelar
                                    </Button>
                                </DialogClose>

                                <Button
                                    type="submit"
                                    data-test="create-team-submit"
                                    disabled={processing}
                                >
                                    Criar equipe
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}
