import { CheckIcon, ChevronDownIcon, SearchIcon, XIcon } from "lucide-react"
import * as React from "react"

import { Input } from "@/components/ui/input"
import { cn } from "@/lib/utils"

export type SearchSelectOption = {
    value: string
    label: string
    group?: string
}

type SearchSelectProps = {
    options: SearchSelectOption[]
    value?: string
    defaultValue?: string
    onValueChange?: (value: string) => void
    name?: string
    placeholder?: string
    searchPlaceholder?: string
    emptyMessage?: string
    title?: string
    disabled?: boolean
    clearable?: boolean
    triggerClassName?: string
}

function normalize(value: string): string {
    return value
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
}

export function SearchSelect({
    options,
    value: controlledValue,
    defaultValue = "",
    onValueChange,
    name,
    placeholder = "Selecione...",
    searchPlaceholder = "Buscar...",
    emptyMessage = "Nenhum resultado encontrado.",
    disabled,
    clearable,
    triggerClassName,
}: SearchSelectProps) {
    const [open, setOpen] = React.useState(false)
    const [search, setSearch] = React.useState("")
    const [internalValue, setInternalValue] = React.useState(defaultValue)
    const containerRef = React.useRef<HTMLDivElement>(null)
    const searchRef = React.useRef<HTMLInputElement>(null)

    const value = controlledValue !== undefined ? controlledValue : internalValue

    const handleChange = React.useCallback(
        (newValue: string) => {
            if (onValueChange) {
                onValueChange(newValue)
            } else {
                setInternalValue(newValue)
            }
        },
        [onValueChange],
    )

    const selected = options.find((option) => option.value === value)

    const filtered = React.useMemo(() => {
        const query = normalize(search.trim())
        if (!query) return options
        return options.filter((option) => normalize(option.label).includes(query))
    }, [options, search])

    const grouped = React.useMemo(() => {
        const groups: Array<{ name?: string; options: SearchSelectOption[] }> = []
        let current: (typeof groups)[number] | undefined
        for (const option of filtered) {
            if (!current || current.name !== option.group) {
                current = { name: option.group, options: [] }
                groups.push(current)
            }
            current.options.push(option)
        }
        return groups
    }, [filtered])

    React.useEffect(() => {
        if (open) {
            setTimeout(() => searchRef.current?.focus(), 0)
        }
    }, [open])

    React.useEffect(() => {
        const handleClickOutside = (event: MouseEvent) => {
            if (containerRef.current && !containerRef.current.contains(event.target as Node)) {
                setOpen(false)
                setSearch("")
            }
        }
        if (open) {
            document.addEventListener("mousedown", handleClickOutside)
            return () => document.removeEventListener("mousedown", handleClickOutside)
        }
    }, [open])

    const selectOption = React.useCallback(
        (option: SearchSelectOption) => {
            handleChange(option.value)
            setOpen(false)
            setSearch("")
        },
        [handleChange],
    )

    return (
        <>
            {name && <input type="hidden" name={name} value={value} />}
            <div ref={containerRef} className="relative">
                <button
                    type="button"
                    disabled={disabled}
                    onClick={() => {
                        if (!disabled) {
                            setOpen((prev) => !prev)
                            setSearch("")
                        }
                    }}
                    className={cn(
                        "border-input data-[placeholder]:text-muted-foreground [&_svg:not([class*='text-'])]:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] flex h-9 w-full items-center justify-between gap-2 rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition-[color,box-shadow] outline-none disabled:cursor-not-allowed disabled:opacity-50",
                        open && "border-ring ring-ring/50 ring-[3px]",
                        triggerClassName,
                    )}
                >
                    <span className="flex min-w-0 flex-1 items-center gap-2 text-left">
                        <span className={cn("truncate", !selected && "text-muted-foreground")}>
                            {selected ? selected.label : placeholder}
                        </span>
                    </span>
                    {clearable && selected && !disabled ? (
                        <span
                            role="button"
                            tabIndex={-1}
                            aria-label="Limpar seleção"
                            className="rounded-sm p-0.5 transition-colors hover:bg-accent hover:text-accent-foreground"
                            onClick={(event) => {
                                event.stopPropagation()
                                handleChange("")
                            }}
                        >
                            <XIcon className="size-4" />
                        </span>
                    ) : (
                        <ChevronDownIcon className={cn("size-4 opacity-50 transition-transform", open && "rotate-180")} />
                    )}
                </button>

                {open && (
                    <div className="absolute z-50 mt-1 w-full min-w-[200px] overflow-hidden rounded-md border bg-popover p-1 text-popover-foreground shadow-md animate-in fade-in-0 zoom-in-95">
                        <div className="relative mb-1">
                            <SearchIcon className="text-muted-foreground pointer-events-none absolute top-1/2 left-2.5 size-3.5 -translate-y-1/2" />
                            <Input
                                ref={searchRef}
                                value={search}
                                onChange={(event) => setSearch(event.target.value)}
                                placeholder={searchPlaceholder}
                                className="h-8 pl-8 text-sm"
                            />
                        </div>
                        <div className="max-h-60 overflow-y-auto">
                            {grouped.length === 0 && (
                                <p className="text-muted-foreground px-2 py-4 text-center text-sm">
                                    {emptyMessage}
                                </p>
                            )}
                            {grouped.map((group) => (
                                <div key={group.name ?? "__ungrouped__"} className="py-0.5">
                                    {group.name && (
                                        <p className="text-muted-foreground px-2 pt-1.5 pb-0.5 text-xs font-medium">
                                            {group.name}
                                        </p>
                                    )}
                                    {group.options.map((option) => {
                                        const isSelected = option.value === value
                                        return (
                                            <button
                                                key={option.value}
                                                type="button"
                                                onClick={() => selectOption(option)}
                                                className={cn(
                                                    "focus:bg-accent flex w-full items-center justify-between gap-2 rounded-sm px-2 py-1.5 text-left text-sm transition-colors outline-none",
                                                    isSelected
                                                        ? "bg-accent text-accent-foreground"
                                                        : "hover:bg-accent",
                                                )}
                                            >
                                                <span className="truncate">{option.label}</span>
                                                {isSelected && <CheckIcon className="size-3.5 shrink-0" />}
                                            </button>
                                        )
                                    })}
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </>
    )
}
