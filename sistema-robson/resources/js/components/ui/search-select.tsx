import { CheckIcon, ChevronDownIcon, SearchIcon, XIcon } from "lucide-react"
import * as React from "react"

import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog"
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
    onValueChange: (value: string) => void
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
    value,
    onValueChange,
    placeholder = "Selecione...",
    searchPlaceholder = "Buscar...",
    emptyMessage = "Nenhum resultado encontrado.",
    title = "Selecione uma opção",
    disabled,
    clearable,
    triggerClassName,
}: SearchSelectProps) {
    const [open, setOpen] = React.useState(false)
    const [search, setSearch] = React.useState("")

    const selected = options.find((option) => option.value === value)

    const filtered = React.useMemo(() => {
        const query = normalize(search.trim())

        if (!query) {
            return options
        }

        return options.filter((option) =>
            normalize(option.label).includes(query),
        )
    }, [options, search])

    const grouped = React.useMemo(() => {
        const groups: Array<{ name?: string; options: SearchSelectOption[] }> =
            []
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

    const handleOpenChange = React.useCallback((next: boolean) => {
        setOpen(next)

        if (!next) {
            setSearch("")
        }
    }, [])

    const selectOption = React.useCallback(
        (option: SearchSelectOption) => {
            onValueChange(option.value)
            setOpen(false)
            setSearch("")
        },
        [onValueChange],
    )

    return (
        <Dialog open={open} onOpenChange={handleOpenChange}>
            <DialogTrigger asChild>
                <button
                    type="button"
                    disabled={disabled}
                    className={cn(
                        "border-input data-[placeholder]:text-muted-foreground [&_svg:not([class*='text-'])]:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] flex h-9 w-full items-center justify-between gap-2 rounded-md border bg-transparent px-3 py-2 text-sm whitespace-nowrap shadow-xs transition-[color,box-shadow] outline-none disabled:cursor-not-allowed disabled:opacity-50",
                        triggerClassName,
                    )}
                >
                    <span className="flex min-w-0 flex-1 items-center gap-2 text-left">
                        <span
                            className={cn(
                                "truncate",
                                !selected && "text-muted-foreground",
                            )}
                        >
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
                                onValueChange("")
                            }}
                        >
                            <XIcon className="size-4" />
                        </span>
                    ) : (
                        <ChevronDownIcon className="size-4 opacity-50" />
                    )}
                </button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>{title}</DialogTitle>
                </DialogHeader>
                <div className="relative">
                    <SearchIcon className="text-muted-foreground pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2" />
                    <Input
                        autoFocus
                        value={search}
                        onChange={(event) => setSearch(event.target.value)}
                        placeholder={searchPlaceholder}
                        className="pl-9"
                    />
                </div>
                <div className="max-h-72 overflow-y-auto pr-1">
                    {grouped.length === 0 && (
                        <p className="text-muted-foreground px-2 py-6 text-center text-sm">
                            {emptyMessage}
                        </p>
                    )}
                    {grouped.map((group) => (
                        <div
                            key={group.name ?? "__ungrouped__"}
                            className="py-1"
                        >
                            {group.name && (
                                <p className="text-muted-foreground px-2 pt-2 pb-1 text-xs font-medium">
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
                                        <span className="truncate">
                                            {option.label}
                                        </span>
                                        {isSelected && (
                                            <CheckIcon className="size-4 shrink-0" />
                                        )}
                                    </button>
                                )
                            })}
                        </div>
                    ))}
                </div>
            </DialogContent>
        </Dialog>
    )
}
