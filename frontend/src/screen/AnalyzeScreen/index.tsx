import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useResultType } from 'shared/hooks/useResultType';
import { images } from 'shared/images';

const ANALYZE_DURATION = 1500;

export const AnalyzeScreen = () => {
    const { type, popup } = useResultType();
    const navigate = useNavigate();

    useEffect(() => {
        if (type === null) return;

        const timer = setTimeout(
            () => navigate(`/type_result?type=${type}`, { replace: true }),
            ANALYZE_DURATION,
        );
        return () => clearTimeout(timer);
    }, [type, navigate]);

    if (type === null) return popup;

    return (
        <main className='analyze_container'>
            <section className='analyze_wrap'>
                <div className='analyze_title'>
                    검진 결과를<br/>분석하고 있어요
                </div>
                <div className="analyze_progress"></div>
                <div className="analyze_content">
                    <picture>
                        <source media='(max-width: 768px)' srcSet={images.analysisMo} />
                        <img src={images.analysis} alt='분석 중인 강아지와 노트북' />
                    </picture>
                </div>
                <div className="analyze_chips">
                    <div className="analyze_chip">미끄럼방지</div>
                    <div className="analyze_chip">스크래치방지</div>
                    <div className="analyze_chip">오염방지</div>
                    <div className="analyze_chip">냄새케어</div>
                </div>
            </section>
        </main>
    );
}
