import { useCookies } from 'react-cookie';
import { isKiosk } from 'shared/isKiosk';

export const useTypeCookie = () => {
    const [cookie, setCookie, removeCookie] = useCookies(['type']);

    const createCookie = (types:string) => {
        if (isKiosk) return;
        setCookie('type', types, {
            path: '/',
            maxAge: 28800,
        });
    }

    return { cookie, createCookie, removeCookie };
}