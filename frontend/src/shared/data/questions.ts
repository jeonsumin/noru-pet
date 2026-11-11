export interface Question {
    id: string;
    title: string;
    des: string;
    badge: string;
    options: {
        label: string;
        subLabel: string;
        value: string;
        check?: string;
    }[];
}


export const questionList: Question[] = [
    {
        id: 'Q1',
        title: `우리 집, 어디가\n가장 걱정되나요?`,
        des: '가장 걱정되는 곳 하나만 골라주세요',
        badge: '우리 집 검진',
        options: [
            {
                label: '바닥에서 자주 미끄러져요',
                subLabel: '미끄럼방지 · 거실 · 복도 바닥',
                value: 'A',
            },
            {
                label: '가구, 문틀을 물어뜯거나 긁어요',
                subLabel: '스크래치방지 · 이빨 · 발톱 자국',
                value: 'B',
            },
            {
                label: '벽, 가구 스크래치가 많아요',
                subLabel: '오염방지 · 발자국 · 배변 실수',
                value: 'C',
            },
            {
                label: '집 안 냄새가 신경 쓰여요',
                subLabel: '냄새케어 · 배변 냄새 · 체취',
                value: 'D',
            },
        ],
    },
    {
        id: 'Q2',
        title: `산책 · 놀이 시간,\n우리 아이는?`,
        des: '가장 가까운 모습을 골라주세요',
        badge: '우리 아이 검진',
        options: [
            {
                label: '신나게 뛰어다녀요',
                subLabel: '에너지가 넘쳐요',
                check: 'active',
                value: 'A',
            },
            {
                label: '이것저것 탐색해요',
                subLabel: '바쁘게 다녀요',
                check: 'active',
                value: 'B',
            },
            {
                label: '천천히 걸어요',
                subLabel: '느긋하게 걸어요',
                check: 'calm',
                value: 'C',
            },
            {
                label: '안기거나 쉬고 싶어해요',
                subLabel: '조금 걷고 쉬어요',
                check: 'calm',
                value: 'D',
            },
        ],
    },
    {
        id: 'Q3',
        title: `처음 보는 물건을\n볼 때, 우리 아이는?`,
        des: '가장 가까운 모습을 골라주세요',
        badge: '우리 아이 검진',
        options: [
            {
                label: '바로 달려가요',
                subLabel: '신나서 먼저 다가가요',
                check: 'active',
                value: 'A',
            },
            {
                label: '냄새 맡고 건드려 봐요',
                subLabel: '호기심이 많아요',
                check: 'active',
                value: 'B',
            },
            {
                label: '멀리서 지켜봐요',
                subLabel: '익숙해질 때까지 기다려요',
                check: 'calm',
                value: 'C',
            },
            {
                label: '관심 없이 지나쳐요',
                subLabel: '별로 신경 쓰지 않아요',
                check: 'calm',
                value: 'D',
            },
        ],
    },
    {
        id: 'Q4',
        title: `혼자 있을 때,\n우리 아이는?`,
        des: '가장 가까운 모습을 골라주세요',
        badge: '우리 아이 검진',
        options: [
            {
                label: '집 안을 돌아다녀요',
                subLabel: '구석구석 탐색해요',
                check: 'active',
                value: 'A',
            },
            {
                label: '장난감을 갖고 놀아요',
                subLabel: '혼자서도 잘 놀아요',
                check: 'active',
                value: 'B',
            },
            {
                label: '창밖 · 문 앞을 지켜봐요',
                subLabel: '조용히 기다려요',
                check: 'calm',
                value: 'C',
            },
            {
                label: '자리 잡고 푹 쉬어요',
                subLabel: '좋아하는 자리에서 자요',
                check: 'calm',
                value: 'D',
            },
        ],
    },
];