export interface TypeResult {
  title: string;
  badge: string;
  des: string;
}

export const typeResult: Record<number, TypeResult> = {
    1: {
        badge: '미끄럼방지 · 활동형',
        title: '미끄러지는 개구쟁이',
        des: '신나게 달리다 코너에서 미끄러지는 활동파예요',
    },
    2: {
        badge: '미끄럼방지 · 차분형',
        title: '조심조심 산책가',
        des: '미끄러운 바닥이 불편해 조심조심 걷는 아이예요',
    },
    3: {
        badge: '스크래치방지 · 활동형',
        title: '가구 파괴자',
        des: '소파 다리 · 문틀을 물어뜯는 에너지 넘치는 아이예요',
    },
    4: {
        badge: '스크래치방지 · 차분형',
        title: '긁적긁적 장난꾸러기',
        des: '앞발로 방문과 가구를 긁으며 노는 장난꾸러기예요',
    },
    5: {
        badge: '오염방지 · 활동형',
        title: '얼룩 남기는 탐험가',
        des: '산책하고 돌아온 발, 집 안 곳곳에 탐험 흔적이 남아요',
    },
    6: {
        badge: '오염방지 · 차분형',
        title: '실수 잦은 순둥이',
        des: '배변 · 식사 실수로 벽 주변이 자주 더러워져요',
    },
    7: {
        badge: '냄새케어 · 활동형',
        title: '영역 표시 대장',
        des: '배변 공간 · 마킹 자리에 냄새 흔적을 남기는 아이예요',
    },
    8: {
        badge: '냄새케어 · 차분형',
        title: '꼬순내 뿜뿜 단짝',
        des: '소파 · 쿠션 곳곳에 포근한 체취를 남기는 단짝이에요',
    },
};
 