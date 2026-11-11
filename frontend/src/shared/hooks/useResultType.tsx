import { useNavigate, useSearchParams } from 'react-router-dom';
import { Popup } from 'shared/ui/Popup';

export const useResultType = () => {
    const [params] = useSearchParams();
    const navigate = useNavigate();
    const raw = params.get('type');
    const type = /^[1-8]$/.test(raw ?? '') ? Number(raw) : null;

    const popup = (
        <Popup
            icon="alert"
            title="잘못된 접근이에요"
            des="처음 화면에서 다시 시작해주세요"
            buttons={[{ text: '확인', onClick: () => navigate('/', { replace: true }) }]}
        />
    );

    return { type, popup };
};
