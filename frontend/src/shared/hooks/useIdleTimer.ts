import { useCallback, useEffect, useRef, useState } from 'react';
import { useNavigate } from 'react-router-dom';

const IDLE_SEC = 10;
const COUNTDOWN_SEC = 10;
const DIRECT_SEC = 20;


export const useIdleTimer = (enabled: boolean, direct = false) => {
    const navigate = useNavigate();
    const [left, setLeft] = useState<number | null>(null);
    const timer = useRef<number>(undefined);

    const reset = useCallback(() => {
        clearTimeout(timer.current);
        setLeft(enabled && direct ? DIRECT_SEC : null);
        if (enabled && !direct) timer.current = window.setTimeout(() => setLeft(COUNTDOWN_SEC), IDLE_SEC * 1000);
    }, [enabled, direct]);

    useEffect(() => {
        reset();
        window.addEventListener('click', reset);
        return () => {
            clearTimeout(timer.current);
            window.removeEventListener('click', reset);
        };
    }, [reset]);

    useEffect(() => {
        if (left === null) return;
        if (left === 0) {
            navigate('/', { replace: true });
            return;
        }
        const t = window.setTimeout(() => setLeft(left - 1), 1000);
        return () => clearTimeout(t);
    }, [left, navigate]);

    return { left, reset };
};
