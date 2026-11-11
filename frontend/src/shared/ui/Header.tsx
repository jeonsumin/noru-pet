import clsx from 'clsx';
import { useState } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { images } from 'shared/images';
import { isKiosk } from 'shared/isKiosk';
import { Popup } from 'shared/ui/Popup';

const confirmPaths = isKiosk ? ['/quest', '/type_result', '/presc'] : ['/quest', '/type_result'];

export interface HeaderProps {
  title?: string;
  type?: 'main' | 'quest' | 'analyze';
}
export const Header = ({title, type}:HeaderProps) => {
  const navigate = useNavigate();
  const { pathname } = useLocation();
  const [confirmOpen, setConfirmOpen] = useState(false);

  return (
    <header>
      <div className={clsx('header', type)}>
        <div className='logo_box'>
          <img src={images.logo} alt='logo' />
          {title && <div className='logo_title'>{title}</div>}
        </div>
        {type === 'quest' && (
          <button type='button' className='hd_button' onClick={() => (confirmPaths.includes(pathname) ? setConfirmOpen(true) : navigate('/'))}>
            처음으로
          </button>
        )}
      </div>
      {confirmOpen && (
        <Popup
          icon='paw'
          title='검진을 그만할까요?'
          des='지금까지 응답은 저장되지 않아요'
          buttons={[
            { text: '그만하기', bgColor: 'white', onClick: () => { setConfirmOpen(false); navigate('/'); } },
            { text: '계속하기', onClick: () => setConfirmOpen(false) },
          ]}
        />
      )}
    </header>
  );
}
