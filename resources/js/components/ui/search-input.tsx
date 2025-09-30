import * as React from "react"
import { Search, X, Command } from "lucide-react"
import { cn } from "@/lib/utils"
import { Button } from "@/components/ui/button"

interface SearchInputProps extends React.ComponentProps<"input"> {
  onClear?: () => void;
  showClearButton?: boolean;
  showSearchKeyboard?: boolean;
}

const SearchInput = React.forwardRef<HTMLInputElement, SearchInputProps>(
  ({ className, onClear, showClearButton = true, showSearchKeyboard = false, value, ...props }, ref) => {
    const [isFocused, setIsFocused] = React.useState(false)
    const inputRef = React.useRef<HTMLInputElement>(null)

    // Use forwarded ref if provided, otherwise use internal ref
    const mergedRef = React.useMemo(() => {
      if (typeof ref === 'function') {
        return (node: HTMLInputElement) => {
          ref(node)
          if (inputRef.current !== node) {
            inputRef.current = node
          }
        }
      } else if (ref) {
        return ref
      }
      return inputRef
    }, [ref])

    // Handle keyboard shortcuts
    React.useEffect(() => {
      const handleKeyDown = (event: KeyboardEvent) => {
        // Cmd+K or Ctrl+K to focus search
        if ((event.metaKey || event.ctrlKey) && event.key === 'k') {
          event.preventDefault()
          inputRef.current?.focus()
        }
        // Escape to clear and blur
        if (event.key === 'Escape' && document.activeElement === inputRef.current) {
          event.preventDefault()
          if (value) {
            onClear?.()
            if (props.onChange) {
              const event = {
                target: { value: '' }
              } as React.ChangeEvent<HTMLInputElement>
              props.onChange(event)
            }
          } else {
            inputRef.current?.blur()
          }
        }
      }

      document.addEventListener('keydown', handleKeyDown)
      return () => document.removeEventListener('keydown', handleKeyDown)
    }, [value, onClear, props.onChange])

    return (
      <div className="relative group">
        <div
          className={cn(
            "relative flex items-center",
            "border border-input rounded-xl bg-background/95 backdrop-blur-sm transition-all duration-200",
            "shadow-sm hover:shadow-md group-hover:border-ring/50",
            isFocused && "border-ring ring-2 ring-ring/20 shadow-lg",
            className
          )}
        >
          <Search 
            className={cn(
              "absolute left-4 h-5 w-5 transition-colors duration-200",
              isFocused ? "text-primary" : "text-muted-foreground group-hover:text-ring"
            )} 
          />
          <input
            ref={mergedRef}
            className={cn(
              "flex h-12 w-full bg-transparent pl-12 text-sm transition-colors",
              "placeholder:text-muted-foreground",
              "focus:outline-none",
              "disabled:cursor-not-allowed disabled:opacity-50",
              showClearButton && value ? "pr-20" : showSearchKeyboard ? "pr-16" : "pr-4"
            )}
            value={value}
            onFocus={() => setIsFocused(true)}
            onBlur={() => setIsFocused(false)}
            {...props}
          />
          
          {/* Keyboard shortcut hint */}
          {showSearchKeyboard && !isFocused && !value && (
            <div className="absolute right-3 flex items-center space-x-1 text-xs text-muted-foreground">
              <Command className="h-3 w-3" />
              <span>K</span>
            </div>
          )}

          {/* Clear button */}
          {showClearButton && value && (
            <Button
              type="button"
              variant="ghost"
              size="sm"
              className="absolute right-2 h-8 w-8 p-0 hover:bg-muted/80 transition-colors"
              onClick={() => {
                onClear?.()
                // Also trigger onChange with empty value for controlled components
                if (props.onChange) {
                  const event = {
                    target: { value: '' }
                  } as React.ChangeEvent<HTMLInputElement>
                  props.onChange(event)
                }
                // Keep focus on input after clearing
                inputRef.current?.focus()
              }}
            >
              <X className="h-4 w-4" />
              <span className="sr-only">Clear search</span>
            </Button>
          )}
        </div>
      </div>
    )
  }
)

SearchInput.displayName = "SearchInput"

export { SearchInput }