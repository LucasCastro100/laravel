import { Link } from '@inertiajs/react';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/hooks/use-current-url';
import type { NavItem } from '@/types';

const navLabels: Record<string, string> = {
    'sidebar.dashboard': 'Painel',
    'sidebar.repository': 'Repositório',
    'sidebar.documentation': 'Documentação',
    'sidebar.selectTeam': 'Selecionar equipe',
    'sidebar.teams': 'Equipes',
    'sidebar.newTeam': 'Nova equipe',
    'sidebar.settings': 'Configurações',
    'sidebar.logOut': 'Sair',
};

export function NavMain({ items = [] }: { items: NavItem[] }) {
    const { isCurrentUrl } = useCurrentUrl();

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel>Plataforma</SidebarGroupLabel>
            <SidebarMenu>
                {items.map((item) => (
                    <SidebarMenuItem key={item.title}>
                        <SidebarMenuButton
                            asChild
                            isActive={isCurrentUrl(item.href)}
                            tooltip={{ children: navLabels[item.title] ?? item.title }}
                        >
                            <Link href={item.href} prefetch>
                                {item.icon && <item.icon />}
                                <span>{navLabels[item.title] ?? item.title}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                ))}
            </SidebarMenu>
        </SidebarGroup>
    );
}
