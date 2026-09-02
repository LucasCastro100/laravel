import { Check, type LucideIcon } from 'lucide-react';

import { cn } from '@/lib/utils';

export type StepItem = {
    label: string;
    icon?: LucideIcon;
};

type StepperProps = {
    steps: StepItem[];
    current: number;
    onStepChange?: (step: number) => void;
    className?: string;
};

/**
 * A modern multi-step progress indicator. Completed steps show a filled
 * circle with a check mark, the active step gets a glowing ring, and the
 * connecting track fills up as the user progresses. On small screens it
 * collapses into a compact summary showing only the current step.
 */
export function Stepper({ steps, current, onStepChange, className }: StepperProps) {
    return (
        <div className={cn('w-full', className)}>
            <div className="relative hidden sm:block">
                <div className="absolute left-0 right-0 top-5 h-0.5 -translate-y-1/2 rounded-full bg-muted" />
                <div
                    className="absolute left-0 top-5 h-0.5 -translate-y-1/2 rounded-full bg-primary transition-all duration-500 ease-out"
                    style={{ width: `${(current / (steps.length - 1)) * 100}%` }}
                />
                <div
                    className="relative grid"
                    style={{ gridTemplateColumns: `repeat(${steps.length}, minmax(0, 1fr))` }}
                >
                    {steps.map((step, i) => {
                        const Icon = step.icon;
                        const isDone = i < current;
                        const isActive = i === current;

                        return (
                            <button
                                type="button"
                                key={step.label}
                                onClick={() => isDone && onStepChange?.(i)}
                                disabled={!isDone && !isActive}
                                className="group flex flex-col items-center gap-2 outline-none"
                            >
                                <div
                                    className={cn(
                                        'flex size-10 items-center justify-center rounded-full border-2 transition-all duration-300',
                                        isDone
                                            ? 'border-primary bg-primary text-primary-foreground'
                                            : isActive
                                              ? 'border-primary bg-background text-primary ring-2 ring-primary ring-offset-2 ring-offset-background shadow-sm'
                                              : 'border-muted bg-muted/40 text-muted-foreground',
                                    )}
                                >
                                    {isDone ? (
                                        <Check className="size-5" strokeWidth={2.5} />
                                    ) : Icon ? (
                                        <Icon className="size-5" />
                                    ) : (
                                        i + 1
                                    )}
                                </div>
                                <span
                                    className={cn(
                                        'text-xs font-medium transition-colors',
                                        isActive
                                            ? 'text-foreground'
                                            : isDone
                                              ? 'text-muted-foreground'
                                              : 'text-muted-foreground/60',
                                    )}
                                >
                                    {step.label}
                                </span>
                            </button>
                        );
                    })}
                </div>
            </div>

            <div className="flex items-center gap-2 text-sm sm:hidden">
                {steps.map((step, i) => {
                    const isDone = i < current;
                    const isActive = i === current;

                    return (
                        <span className="flex items-center gap-2" key={step.label}>
                            <span
                                className={cn(
                                    'flex size-6 items-center justify-center rounded-full text-xs',
                                    isDone || isActive ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground',
                                )}
                            >
                                {isDone ? <Check className="size-3.5" /> : i + 1}
                            </span>
                            {isActive && <span className="text-sm font-medium">{step.label}</span>}
                            {i < steps.length - 1 && <span className="text-muted-foreground">—</span>}
                        </span>
                    );
                })}
            </div>
        </div>
    );
}
