import clsx from 'clsx';
import { images } from 'shared/images';

export interface ButtonProps {
    text: string;
    arrow?: boolean;
    bgColor?: 'white' | 'key' ;
    count?: number;
    onClick?: () => void;
}

export const Button = ({ text, arrow, bgColor='key', count, onClick }: ButtonProps) => {
  return (
    <button
      type='button'
      onClick={onClick}
      className={clsx(
        'buttons',
        arrow && 'arrow',
        count !== undefined && 'has_count',
        bgColor,
      )}
    >
      <span>{text}</span>
      {count !== undefined && <span className='count'>{count}</span>}
      {arrow && <img src={images.arrow} alt='arrow' />}
    </button>
  );
};