import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/hooks/use-current-url';
import { navLabels } from '@/hooks/use-main-nav';
import type { NavItem } from '@/types';
import { Link } from '@inertiajs/react';

export function NavMain({
    items = [],
    label = 'Plataforma',
}: { items: NavItem[]; label?: string }) {
    const { isCurrentUrl } = useCurrentUrl();

    if (items.length === 0) {
        return null;
    }

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel>{label}</SidebarGroupLabel>
            <SidebarMenu>
                {items.map((item) => (
                    <SidebarMenuItem key={item.title}>
                        <SidebarMenuButton
                            asChild
                            isActive={isCurrentUrl(item.href)}
                            tooltip={{
                                children: navLabels[item.title] ?? item.title,
                            }}
                        >
                            <Link href={item.href} prefetch>
                                {item.icon && <item.icon />}
                                <span>
                                    {navLabels[item.title] ?? item.title}
                                </span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                ))}
            </SidebarMenu>
        </SidebarGroup>
    );
}
