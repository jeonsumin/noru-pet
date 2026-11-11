export interface TypePresc {
    title: string;
    label: string;
    productTitle: string;
    productDes: string;
}
export const presc: Record<number, TypePresc> = {
    1: {
        title: `신나게 달려도\n안심되는 바닥부터`,
        label: '실내 마루 · 타일 바닥용',
        productTitle: '노루와 논슬립 펫',
        productDes: `신나게 달리는 거실 · 복도 바닥, 논슬립 코팅으로\n미끄럼 위험을 줄여요`,
    },
    2: {
        title: `조심조심 걷는 아이에게\n덜 미끄러운 바닥을`,
        label: '실내 마루 · 타일 바닥용',
        productTitle: '노루와 논슬립 펫',
        productDes: `조심조심 걷던 반들반들한 바닥,\n논슬립 코팅으로 미끄럼 위험을 줄여요`,
    },
    3: {
        title: `물어뜯기 쉬운 가구 · 문틀,\n스크래치부터 지켜요`,
        label: '목재 가구 · 문틀용',
        productTitle: '노루와 바니쉬 펫',
        productDes: `이빨 자국이 남던 소파 다리 · 문틀,\n투명 코팅으로 목재 표면을 보호해요`,
    },
    4: {
        title: `긁적긁적 스크래치,\n목재 표면을 코팅으로 보호해요`,
        label: '목재 가구 · 문틀용',
        productTitle: '노루와 바니쉬 펫',
        productDes:
            '발톱 긁힘이 남던 방문 · 가구,\n투명 코팅으로 표면 내구성을 높여요',
    },
    5: {
        title: `얼룩 · 긁힘 걱정 줄이고\n벽부터 가구까지 오래도록`,
        label: '벽면·방문·가구용',
        productTitle: '노루와 이지케어 펫',
        productDes: `산책 발자국 · 긁힘 자국이 남는 공간,\n오염, 긁힘에 강한 유색 페인트로 관리해요`,
    },
    6: {
        title: `생활 오염과 긁힘에도\n벽부터 방문까지 깔끔하게`,
        label: '벽면·방문·가구용',
        productTitle: '노루와 이지케어 펫',
        productDes: `실수 얼룩이 잦은 배변 공간 · 밥자리 벽,\n오염에 강한 유색 페인트로 관리해요`,
    },
    7: {
        title: `냄새 흔적 걱정은\n배변 공간부터 관리해요`,
        label: '탈취 스프레이',
        productTitle: '노루와 프레쉬 펫',
        productDes: `냄새가 남던 배변 공간 · 마킹 자리,\n탈취 스프레이로 쾌적하게 관리해요`,
    },
    8: {
        title: `함께 머무는 공간,\n냄새 걱정 없이 쾌적하게`,
        label: '탈취 스프레이',
        productTitle: '노루와 프레쉬 펫',
        productDes: `체취가 배는 소파 주변 · 방 안 공간,\n탈취 스프레이로 쾌적하게 관리해요`,
    },
};