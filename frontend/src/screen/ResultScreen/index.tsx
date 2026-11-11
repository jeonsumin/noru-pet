import { Footer } from 'shared/ui/Footer';
import { images } from 'shared/images';
import { useResultType } from 'shared/hooks/useResultType';
import { useEffect } from 'react';

export const ResultScreen = () => {
    const { type, popup } = useResultType();
    if (type === null) return popup;

    useEffect(() => {
        console.log(type)
    }, [type])

    return (
        <>
            <main>
                <section className='wrap_v2'>
                    <div className='result_title_box'>
                        <div className='result_badge'>내 처방전 QR</div>
                        <div className='result_title'>
                            처방전을 휴대폰에 담고
                            <br />
                            리워드를 받아가세요
                        </div>
                    </div>
                    <div className='result_qr_box'>
                        <img src={images[`qr_${type}` as keyof typeof images]} alt='QR' />
                        <div>휴대폰 카메라로 QR을 스캔하세요</div>
                    </div>
                    <div className='result_goods_box'>
                        <img src={images.goods} alt='goods' />
                        <div>
                            <div className='result_goods_title'>펫 굿즈 증정</div>
                            <div className='result_goods_des'>
                                QR을 스캔한 모바일 처방전 화면을
                                <br />
                                부스 인포메이션 스태프에게 보여주세요
                            </div>
                            <div className='result_goods_sale'>
                                <span>제품 4종 현장 구매시</span>
                                <div>
                                    <span>추가</span>
                                    <strong>10%</strong>
                                    <span>할인</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <Footer line button={{ text: '처음으로', to: '/' }} />
        </>
    );
}