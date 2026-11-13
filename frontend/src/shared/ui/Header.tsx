import clsx from 'clsx';
import { useRef, useState } from 'react';
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
  const [exitOpen, setExitOpen] = useState(false);
  const tapCount = useRef(0);
  const tapTimer = useRef<ReturnType<typeof setTimeout>>(undefined);

  const onLogoTap = () => {
    if (!isKiosk) return;
    clearTimeout(tapTimer.current);
    tapCount.current += 1;
    if (tapCount.current >= 5) {
      tapCount.current = 0;
      setExitOpen(true);
      return;
    }
    tapTimer.current = setTimeout(() => { tapCount.current = 0; }, 1000);
  };

  return (
    <header>
      <div className={clsx('header', type)}>
        <div className='logo_box'>
          <img src={images.logo} alt='logo' onClick={onLogoTap} />
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
      {exitOpen && (
        <Popup
          icon='alert'
          title='앱을 종료하시겠습니까?'
          buttons={[
            { text: '종료하기', bgColor: 'white', onClick: () => window.baseAPI?.closeWindow() },
            { text: '취소', onClick: () => setExitOpen(false) },
          ]}
        />
      )}
    </header>
  );
}
