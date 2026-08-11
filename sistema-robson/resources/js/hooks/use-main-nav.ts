import { usePage } from '@inertiajs/react';
import { CreditCard, LayoutGrid } from 'lucide-react';
import { dashboard } from '@/routes';
import { index as assinaturaIndex } from '@/routes/assinatura';
import type { NavItem } from '@/types';

export const navLabels: Record<string, string> = {
    'sidebar.dashboard': 'Painel',
    'sidebar.assinatura': 'Assinatura',
    'sidebar.repository': 'Repositório',
    'sidebar.documentation': 'Documentação',
    'sidebar.selectTeam': 'Selecionar equipe',
    'sidebar.teams': 'Equipes',
    'sidebar.newTeam': 'Nova equipe',
    'sidebar.settings': 'Configurações',
    'sidebar.logOut': 'Sair',
};

export function useMainNav() {
    const page = usePage();
    const dashboardUrl = page.props.currentTeam
        ? dashboard(page.props.currentTeam.slug)
        : '/';

    const items: NavItem[] = [
        {
            title: 'sidebar.dashboard',
            href: dashboardUrl,
            icon: LayoutGrid,
        },
        {
            title: 'sidebar.assinatura',
            href: assinaturaIndex(),
            icon: CreditCard,
        },
    ];

    return { items, dashboardUrl };
}
