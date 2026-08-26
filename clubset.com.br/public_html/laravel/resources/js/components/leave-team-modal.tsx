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
// import { leave as leaveTeamAction } from '@/routes/teams';
import type { Team } from '@/types';

type Props = {
    team: Team | null;
    open: boolean;
    onOpenChange: (open: boolean) => void;
};

export default function LeaveTeamModal({ team, open, onOpenChange }: Props) {
    const [processing] = useState(false);

    const leaveTeam = () => {
        if (!team) {
            return;
        }

        // Leave team action commented out per request
        // router.visit(leaveTeamAction(team.slug), {
        //     onStart: () => setProcessing(true),
        //     onFinish: () => setProcessing(false),
        //     onSuccess: () => onOpenChange(false),
        // });
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Sair da equipe</DialogTitle>
                    <DialogDescription>
                        {`Tem certeza de que deseja sair de ${team?.name}?`}
                    </DialogDescription>
                </DialogHeader>

                <DialogFooter className="gap-2">
                    <DialogClose asChild>
                        <Button variant="secondary">
                            Cancelar
                        </Button>
                    </DialogClose>

                    <Button
                        variant="destructive"
                        data-test="leave-team-confirm"
                        disabled={processing}
                        onClick={leaveTeam}
                    >
                        Sair da equipe
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
