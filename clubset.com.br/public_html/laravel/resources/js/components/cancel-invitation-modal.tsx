// import { router } from '@inertiajs/react';
import { useState } from 'react';
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
// import { destroy as destroyInvitation } from '@/routes/teams/invitations';
import type { Team, TeamInvitation } from '@/types';

type Props = {
    team: Team;
    invitation: TeamInvitation | null;
    open: boolean;
    onOpenChange: (open: boolean) => void;
};

export default function CancelInvitationModal({
    invitation,
    open,
    onOpenChange,
}: Props) {
    const [processing] = useState(false);

    const cancelInvitation = () => {
        if (!invitation) {
            return;
        }

        // Cancel invitation action commented out per request
        // router.visit(destroyInvitation([team.slug, invitation.code]), {
        //     onStart: () => setProcessing(true),
        //     onFinish: () => setProcessing(false),
        //     onSuccess: () => onOpenChange(false),
        // });
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Cancelar convite</DialogTitle>
                    <DialogDescription>
                        {`Tem certeza de que deseja cancelar o convite para ${invitation?.email}?`}
                    </DialogDescription>
                </DialogHeader>

                <DialogFooter className="gap-2">
                    <DialogClose asChild>
                        <Button variant="secondary">
                            Manter convite
                        </Button>
                    </DialogClose>

                    <Button
                        variant="destructive"
                        data-test="cancel-invitation-confirm"
                        disabled={processing}
                        onClick={cancelInvitation}
                    >
                        Cancelar convite
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
