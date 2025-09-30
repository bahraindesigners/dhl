import { useState, useEffect, useCallback } from 'react';

export function useDebounce<T>(value: T, delay: number): T {
    const [debouncedValue, setDebouncedValue] = useState<T>(value);

    useEffect(() => {
        const handler = setTimeout(() => {
            setDebouncedValue(value);
        }, delay);

        return () => {
            clearTimeout(handler);
        };
    }, [value, delay]);

    return debouncedValue;
}

export function useDebouncedSearch(initialValue: string = '', delay: number = 300) {
    const [searchQuery, setSearchQuery] = useState(initialValue);
    const debouncedSearchQuery = useDebounce(searchQuery, delay);

    const handleSearchChange = useCallback((value: string) => {
        setSearchQuery(value);
    }, []);

    const clearSearch = useCallback(() => {
        setSearchQuery('');
    }, []);

    return {
        searchQuery,
        debouncedSearchQuery,
        handleSearchChange,
        clearSearch,
    };
}