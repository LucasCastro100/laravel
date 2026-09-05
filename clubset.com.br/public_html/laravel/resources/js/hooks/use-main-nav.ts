import { dashboard } from '@/routes';
import { index as adminIndex } from '@/routes/admin';
import { diagnosticos as adminDiagnosticos } from '@/routes/admin';
import { moderation as adminModeration } from '@/routes/admin';
import { registrations as adminRegistrations } from '@/routes/admin';
import { settings as adminSettings } from '@/routes/admin';
import { index as assinaturaIndex } from '@/routes/assinatura';
import { index as listingsIndex } from '@/routes/listings';
import { index as matchesIndex } from '@/routes/matches';
import { index as permutasIndex } from '@/routes/permutas';
import { edit as profileEdit } from '@/routes/profile';
import { index as servicesIndex } from '@/routes/services';
import type { NavItem } from '@/types';
import { usePage } from '@inertiajs/react';
import {
    BarChart3,
    Camera,
    ChartColumn,
    CreditCard,
    FileCheck,
    Handshake,
    LayoutGrid,
    Repeat,
    Settings,
    Shield,
    Store,
    UserRound,
} from 'lucide-react';

export const navLabels: Record<string, string> = {
    'sidebar.dashboard': 'Painel',
    'sidebar.assinatura': 'Assinatura',
    'sidebar.listings': 'Anúncios',
    'sidebar.services': 'Serviços',
    'sidebar.matches': 'Matches',
    'sidebar.permutas': 'Permutas',
    'sidebar.admin': 'Painel Admin',
    'sidebar.moderation': 'Moderação',
    'sidebar.registrations': 'Cadastros',
    'sidebar.diagnosticos': 'Diagnósticos',
    'sidebar.adminSettings': 'Config. Plataforma',
    'sidebar.settings': 'Configurações',
    'sidebar.logOut': 'Sair',
};

export function useMainNav() {
    const { auth } = usePage().props as {
        auth: {
            user?: {
                is_admin?: boolean;
                admin_verified_at?: string | null;
            };
        };
    };
    const user = auth.user;
    const isAdmin = user?.is_admin === true;
    const isPending =
        user !== undefined && !isAdmin && user.admin_verified_at == null;
    const dashboardUrl = isPending ? profileEdit().url : dashboard().url;

    const items: NavItem[] = [
        {
            title: 'sidebar.dashboard',
            href: dashboardUrl,
            icon: LayoutGrid,
        },
        {
            title: 'sidebar.listings',
            href: listingsIndex().url,
            icon: Store,
        },
        {
            title: 'sidebar.services',
            href: servicesIndex().url,
            icon: Camera,
        },
        {
            title: 'sidebar.matches',
            href: matchesIndex().url,
            icon: Handshake,
        },
        {
            title: 'sidebar.permutas',
            href: permutasIndex().url,
            icon: Repeat,
        },
        {
            title: 'sidebar.assinatura',
            href: assinaturaIndex().url,
            icon: CreditCard,
        },
    ];

    const adminItems: NavItem[] = isAdmin
        ? [
              {
                  title: 'sidebar.admin',
                  href: adminIndex().url,
                  icon: Shield,
              },
              {
                  title: 'sidebar.moderation',
                  href: adminModeration().url,
                  icon: FileCheck,
              },
              {
                  title: 'sidebar.registrations',
                  href: adminRegistrations().url,
                  icon: UserRound,
              },
              {
                  title: 'sidebar.diagnosticos',
                  href: adminDiagnosticos().url,
                  icon: ChartColumn,
              },
              {
                  title: 'sidebar.adminSettings',
                  href: adminSettings().url,
                  icon: Settings,
              },
          ]
        : [];

    return { items: isPending ? [] : items, adminItems, dashboardUrl };
}
