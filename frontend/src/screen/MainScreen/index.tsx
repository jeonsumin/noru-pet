import { useLayoutEffect, useRef } from 'react';
import lottie from 'lottie-web';
import houseKiosk from 'shared/images/noroowa_house_kiosk.json';
import { Footer } from 'shared/ui/Footer';
export const MainScreen = () => {
  const lottieRef = useRef<HTMLDivElement>(null);

  useLayoutEffect(() => {
    const anim = lottie.loadAnimation({
      container: lottieRef.current!,
      renderer: 'svg',
      loop: true,
      autoplay: true,
      animationData: houseKiosk,
    });
    const swaps = houseKiosk.markers
      .filter((m) => m.cm.startsWith('swap_'))
      .map((m) => m.tm)
      .sort((a, b) => a - b);
    const colors = ['--color2', '--color3', '--color4', '--color1'];
    const root = document.documentElement.style;
    let current = -1;
    const onFrame = () => {
      const index = swaps.filter((t) => anim.currentFrame >= t).length % colors.length;
      if (index === current) return;
      current = index;
      root.setProperty('--main-bg', `var(${colors[index]})`);
    };
    onFrame();
    anim.addEventListener('enterFrame', onFrame);
    return () => {
      anim.destroy();
      root.removeProperty('--main-bg');    };
  }, []);

  return (
    <>
        <main className='main_screen'>
          <section className='wrap'>
            <div>
              <div className="main_check_zone">PET SAFETY CHECK ZONE</div>
              <div className="main_title">펫 안전 검진존</div>
              <div className="main_des">우리 집, 우리 아이에게 안전할까요?</div>
            </div>
            <div className='main_lottie' ref={lottieRef} />
          </section>
        </main>
        <Footer button={{ text: '검진 시작하기', arrow: true, to: '/quest' }} />
    </>
  );
};
