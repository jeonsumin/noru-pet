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
        setLeft(null);
        if (!enabled) return;
        timer.current = direct
            ? window.setTimeout(() => navigate('/', { replace: true }), DIRECT_SEC * 1000)
            : window.setTimeout(() => setLeft(COUNTDOWN_SEC), IDLE_SEC * 1000);
    }, [enabled, direct, navigate]);

    useEffect(() => {
        reset();
        window.addEventListener('pointerdown', reset);
        return () => {
            clearTimeout(timer.current);
            window.removeEventListener('pointerdown', reset);
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
