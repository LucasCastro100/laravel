import { Button } from "@/components/ui/button";
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from "@/components/ui/tooltip";
import { cn } from "@/lib/utils";
import { Form, Link } from "@inertiajs/react";
import type { LucideIcon } from "lucide-react";
import type { ComponentProps } from "react";
import type { RouteFormDefinition } from "@/wayfinder";

type ActionIconButtonProps = Omit<
    ComponentProps<typeof Button>,
    "children" | "asChild" | "form"
> & {
    icon: LucideIcon;
    label: string;
    onClick?: () => void;
    form?: RouteFormDefinition<"get" | "post" | "put" | "patch" | "delete">;
    href?: string;
};

export function ActionIconButton({
    icon: Icon,
    label,
    form,
    href,
    onClick,
    type = "button",
    variant = "default",
    size = "icon",
    className,
    "aria-label": ariaLabel,
    ...props
}: ActionIconButtonProps) {
    const button = (
        <Button
            type={form ? "submit" : type}
            variant={variant}
            size={size}
            className={cn("shrink-0", className)}
            aria-label={ariaLabel ?? label}
            onClick={onClick}
            asChild={href !== undefined}
            {...props}
        >
            {href ? (
                <Link href={href}>
                    <Icon className="size-4" />
                </Link>
            ) : (
                <Icon className="size-4" />
            )}
        </Button>
    );

    const withTooltip = (
        <Tooltip>
            <TooltipTrigger asChild>{button}</TooltipTrigger>
            <TooltipContent>{label}</TooltipContent>
        </Tooltip>
    );

    return form ? <Form {...form}>{withTooltip}</Form> : withTooltip;
}