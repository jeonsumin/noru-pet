import { Footer } from 'shared/ui/Footer';
import { useResultType } from 'shared/hooks/useResultType';
import { typeResult } from 'shared/data/typeResult';

export const TypeResultScreen = () => {
    const { type, popup } = useResultType();
    if (type === null) return popup;
    const result = typeResult[type];

    return (
        <>
            <main>
                <section className="wrap_v2">
                    <div className={`type_result_card_box type_${type}`}>
                        <div className="type_result_badge">{result.badge}</div>
                        <div className="type_result_title">{result.title}</div>
                        <div className="type_result_des">{result.des}</div>
                        <div className={`type_result_imgbox type_${type}`}></div>
                    </div>
                </section>
            </main>
            <Footer line button={{ text: '맞춤 처방전 받기', arrow: true, to: '/presc', keepParams: true }} />
        </>
    )
}
