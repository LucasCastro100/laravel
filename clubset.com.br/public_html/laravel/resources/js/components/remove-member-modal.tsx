import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
// import { destroy as destroyMember } from '@/routes/teams/members';
import type { Team, TeamMember } from '@/types';
// import { router } from '@inertiajs/react';
import { useState } from 'react';

type Props = {
    team: Team;
    member: TeamMember | null;
    open: boolean;
    onOpenChange: (open: boolean) => void;
};

export default function RemoveMemberModal({
    member,
    open,
    onOpenChange,
}: Props) {
    const [processing] = useState(false);

    const removeMember = () => {
        if (!member) {
            return;
        }

        // Remove member action commented out per request
        // router.visit(destroyMember([team.slug, member.id]), {
        //     onStart: () => setProcessing(true),
        //     onFinish: () => setProcessing(false),
        //     onSuccess: () => onOpenChange(false),
        // });
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Remover membro da equipe</DialogTitle>
                    <DialogDescription>
                        {`Tem certeza de que deseja remover ${member?.name} desta equipe?`}
                    </DialogDescription>
                </DialogHeader>

                <DialogFooter className="gap-2">
                    <DialogClose asChild>
                        <Button variant="secondary">Cancelar</Button>
                    </DialogClose>

                    <Button
                        variant="destructive"
                        data-test="remove-member-confirm"
                        disabled={processing}
                        onClick={removeMember}
                    >
                        Remover membro
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
