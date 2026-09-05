// import CreateTeamModal from '@/components/create-team-modal';
import { ActionIconButton } from '@/components/action-icon-button';
import Heading from '@/components/heading';
import LeaveTeamModal from '@/components/leave-team-modal';
import { Badge } from '@/components/ui/badge';
// import { edit, index } from '@/routes/teams';
import type { Team } from '@/types';
import { Head } from '@inertiajs/react';
import { Eye, LogOut, Pencil } from 'lucide-react';
import { useState } from 'react';

const roleLabels: Record<string, string> = {
    owner: 'Proprietário',
    admin: 'Administrador',
    member: 'Membro',
};

type Props = {
    teams: Team[];
};

export default function TeamsIndex({ teams }: Props) {
    const [leaveTeamDialogOpen, setLeaveTeamDialogOpen] = useState(false);
    const [teamLeaving, setTeamLeaving] = useState<Team | null>(null);

    const openLeaveTeamDialog = (team: Team) => {
        setTeamLeaving(team);
        setLeaveTeamDialogOpen(true);
    };

    return (
        <>
            <Head title="Equipes" />

            <h1 className="sr-only">Equipes</h1>

            <div className="flex flex-col space-y-6">
                <div className="flex items-center justify-between">
                    <Heading
                        variant="small"
                        title="Equipes"
                        description="Gerencie suas equipes e participações"
                    />

                    {/* Create team logic commented out per request
                    <CreateTeamModal>
                        <Button data-test="teams-new-team-button">
                            <Plus /> {'Nova equipe'}
                        </Button>
                    </CreateTeamModal>
                    */}
                </div>

                <div className="space-y-3">
                    {teams.map((team) => {
                        const canLeaveTeam =
                            !team.isPersonal && team.role !== 'owner';

                        return (
                            <div
                                key={team.id}
                                data-test="team-row"
                                className="flex items-center justify-between gap-4 rounded-lg border p-4"
                            >
                                <div className="flex items-center gap-4">
                                    <div>
                                        <div className="flex items-center gap-2">
                                            <span className="font-medium">
                                                {team.name}
                                            </span>
                                            {team.isPersonal ? (
                                                <Badge variant="secondary">
                                                    Pessoal
                                                </Badge>
                                            ) : null}
                                        </div>
                                        <span className="text-sm text-muted-foreground">
                                            {roleLabels[team.role!]}
                                        </span>
                                    </div>
                                </div>

                                <div className="flex items-center gap-2">
                                        {canLeaveTeam ? (
                                            <ActionIconButton
                                                icon={LogOut}
                                                label="Sair da equipe"
                                                variant="ghost"
                                                size="sm"
                                                data-test="team-leave-button"
                                                onClick={() =>
                                                    openLeaveTeamDialog(team)
                                                }
                                            />
                                        ) : null}

                                        {team.role === 'member' ? (
                                            <ActionIconButton
                                                icon={Eye}
                                                label="Ver equipe"
                                                variant="ghost"
                                                size="sm"
                                                data-test="team-view-button"
                                                href="#"
                                            />
                                        ) : (
                                            <ActionIconButton
                                                icon={Pencil}
                                                label="Editar equipe"
                                                variant="ghost"
                                                size="sm"
                                                data-test="team-edit-button"
                                                href="#"
                                            />
                                        )}
                                    </div>
                            </div>
                        );
                    })}

                    {teams.length === 0 ? (
                        <p className="py-8 text-center text-muted-foreground">
                            Você ainda não pertence a nenhuma equipe.
                        </p>
                    ) : null}
                </div>
            </div>

            <LeaveTeamModal
                team={teamLeaving}
                open={leaveTeamDialogOpen}
                onOpenChange={setLeaveTeamDialogOpen}
            />
        </>
    );
}

TeamsIndex.layout = {
    breadcrumbs: [
        {
            title: 'Equipes',
            // href: index(),
            href: '#',
        },
    ],
};
