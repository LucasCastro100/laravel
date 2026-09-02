import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';
import { Plus } from 'lucide-react';
import type { MouseEventHandler, ReactNode } from 'react';

type NewButtonProps = {
    label: string;
    href?: string;
    onClick?: MouseEventHandler<HTMLButtonElement>;
    icon?: ReactNode;
    className?: string;
};

const DefaultIcon = () => <Plus className="size-4" />;

export function NewButton({
    label,
    href,
    onClick,
    icon,
    className,
}: NewButtonProps) {
    if (href) {
        return (
            <Button asChild className={className}>
                <Link href={href}>
                    {icon ?? <DefaultIcon />}
                    {label}
                </Link>
            </Button>
        );
    }

    return (
        <Button onClick={onClick} className={className}>
            {icon ?? <DefaultIcon />}
            {label}
        </Button>
    );
}
