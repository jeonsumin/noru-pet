import { useSyncExternalStore } from 'react';

const query = window.matchMedia('(max-width: 768px)');

const subscribe = (onChange: () => void) => {
    query.addEventListener('change', onChange);
    return () => query.removeEventListener('change', onChange);
};

export const useIsMobile = () => useSyncExternalStore(subscribe, () => query.matches);
