import { useLocation, useNavigate } from 'react-router-dom';
import { Button, type ButtonProps } from 'shared/ui/Button';
import clsx from 'clsx';

export interface FooterProps {
    line?: boolean;
    button: ButtonProps & { to?: string; keepParams?: boolean };
}

export const Footer = ({ line, button }: FooterProps) => {
    const navigate = useNavigate();
    const { search } = useLocation();
    const { to, keepParams } = button;

    return (
        <footer className={clsx(line && 'line')}>
            <div className="footer_wrap">
                <Button
                    {...button}
                    onClick={
                        to
                            ? () => navigate({ pathname: to, search: keepParams ? search : '' })
                            : button.onClick
                    }
                />
            </div>
        </footer>
    )
}
