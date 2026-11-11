import clsx from 'clsx';
import type { ReactNode } from 'react';
import { Button, type ButtonProps } from 'shared/ui/Button';

export interface PopupProps {
    icon: 'alert' | 'paw' | number;
    title: string;
    des?: ReactNode;
    buttons: ButtonProps[];
}

export const Popup = ({ icon, title, des, buttons }: PopupProps) => {
    const isCount = typeof icon === 'number';

    return (
        <div className="popup_dim">
            <div className="popup" role="dialog" aria-modal="true">
                <div className={clsx('popup_icon', isCount ? 'count' : icon)}>
                    {icon === 'alert' ? '!' : isCount ? icon : null}
                </div>
                <div className="popup_title">{title}</div>
                {des && <div className="popup_des">{des}</div>}
                <div className="popup_buttons">
                    {buttons.map((b) => (
                        <Button key={b.text} {...b} />
                    ))}
                </div>
            </div>
        </div>
    );
};
