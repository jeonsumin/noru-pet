import clsx from 'clsx';
import { images } from 'shared/images';

export interface ButtonProps {
    text: string;
    arrow?: boolean;
    bgColor?: 'white' | 'key' ;
    onClick?: () => void;
}

export const Button = ({ text, arrow, bgColor='key', onClick }: ButtonProps) => {
  return (
    <button
      type='button'
      onClick={onClick}
      className={clsx(
        'buttons',
        arrow && 'arrow',
        bgColor,
      )}
    >
      <span>{text}</span>
      {arrow && <img src={images.arrow} alt='arrow' />}
    </button>
  );
};