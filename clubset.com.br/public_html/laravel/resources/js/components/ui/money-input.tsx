import * as React from 'react';
import { cn } from '@/lib/utils';

interface MoneyInputProps extends Omit<React.InputHTMLAttributes<HTMLInputElement>, 'value' | 'onChange'> {
    value?: string;
    onChange?: (value: string) => void;
}

function formatCents(cents: string): string {
    const digits = cents.replace(/\D/g, '');
    if (!digits) return '';
    const num = parseInt(digits, 10);
    const integerPart = Math.floor(num / 100);
    const decimalPart = (num % 100).toString().padStart(2, '0');
    const formatted = integerPart.toLocaleString('pt-BR');
    return `${formatted},${decimalPart}`;
}

export function MoneyInput({ value, onChange, className, placeholder, name, ...props }: MoneyInputProps) {
    const [displayValue, setDisplayValue] = React.useState(() => {
        if (value) {
            const cents = String(value).replace('.', '').replace(',', '');
            return formatCents(cents);
        }
        return '';
    });

    const centsValue = React.useMemo(() => {
        const digits = displayValue.replace(/\D/g, '');
        return digits || '';
    }, [displayValue]);

    const handleChange = React.useCallback(
        (e: React.ChangeEvent<HTMLInputElement>) => {
            const digits = e.target.value.replace(/\D/g, '');
            setDisplayValue(formatCents(digits));
            onChange?.(digits);
        },
        [onChange],
    );

    const handleBlur = React.useCallback(() => {
        if (displayValue && displayValue !== '0,00') {
            const digits = displayValue.replace(/\D/g, '');
            if (digits) {
                setDisplayValue(formatCents(digits));
            }
        }
    }, [displayValue]);

    return (
        <div className="relative">
            {name && <input type="hidden" name={name} value={centsValue} />}
            <span className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-muted-foreground">
                R$
            </span>
            <input
                type="text"
                inputMode="numeric"
                value={displayValue}
                onChange={handleChange}
                onBlur={handleBlur}
                placeholder={placeholder ?? '0,00'}
                className={cn(
                    'border-input flex h-9 w-full rounded-md border bg-transparent pl-10 pr-3 py-1 text-sm shadow-xs transition-[color,box-shadow] outline-none',
                    'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
                    'disabled:cursor-not-allowed disabled:opacity-50',
                    className,
                )}
                {...props}
            />
        </div>
    );
}
