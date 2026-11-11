import { Footer } from 'shared/ui/Footer';
import { useTypeCookie } from 'shared/hooks/useTypeCookie';
import { useResultType } from 'shared/hooks/useResultType';
import { useIsMobile } from 'shared/hooks/useIsMobile';
import { useSearchParams } from 'react-router-dom';
import { presc } from 'shared/data/presc';
import { images } from 'shared/images';

export const PrescScreen = () => {
    const { type, popup } = useResultType();
    const isMobile = useIsMobile();
    const [params] = useSearchParams();
    const { cookie } = useTypeCookie();
    const hasCookie = /^[1-8]$/.test(String(cookie.type));
    if (type === null) return popup;
    const prescItem = presc[type];

    return (
        <>
            <main>
                <section className='wrap_v2'>
                    {params.get('from') === 'qr' && (
                        <div className='presc_qr_notice'>키오스크 검진 결과를 불러왔어요</div>
                    )}
                    <div className='presc_title_box'>
                        <div className='presc_badge'>우리 집 맞춤 처방</div>
                        <div className='presc_title'>{prescItem.title}</div>
                    </div>
                    <div className='presc_card_box'>
                        <div className={`presc_label type_${type}`}>
                            {prescItem.label}
                        </div>
                        <div className={`presc_img type_${type}`}></div>
                        <div className='presc_product_box'>
                            <div className='presc_product_title'>
                                {prescItem.productTitle}
                            </div>
                            <div className='presc_product_des'>
                                {prescItem.productDes}
                            </div>
                        </div>
                    </div>
                    <div className='result_goods_box mo_only'>
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
            {!hasCookie && (
                <Footer
                    line
                    button={
                        isMobile
                            ? { text: '처음으로', to: '/' }
                            : { text: '리워드 받기', arrow: true, to: '/result', keepParams: true }
                    }
                />
            )}
        </>
    );
}
