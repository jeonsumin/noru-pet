import { useEffect, useRef, useState } from 'react';
import axios from 'axios';
import clsx from 'clsx';
import { useNavigate } from 'react-router-dom';
import { questionList } from 'shared/data/questions';
import { images, preloadImage, typeResultImg } from 'shared/images';
import { useIsMobile } from 'shared/hooks/useIsMobile';
import { isKiosk } from 'shared/isKiosk';

const pad = (n: number) => String(n).padStart(2, '0');
const NEXT_DELAY = 500;
const LABELS = ['A', 'B', 'C', 'D'];

const TYPE_TABLE: Record<string, { active: number; calm: number }> = {
  A: { active: 1, calm: 2,},
  B: { active: 3, calm: 4 },
  C: { active: 5, calm: 6 },
  D: { active: 7, calm: 8 },
};

export const QuestionScreen = () => {
  const [index, setIndex] = useState(0);
  const [selected, setSelected] = useState<number[]>([]);
  const navigate = useNavigate();
  const isMobile = useIsMobile();

  const question = questionList[index];
  const step = index + 1;
  const total = questionList.length;

  const timer = useRef<ReturnType<typeof setTimeout>>(undefined);

  const surveyId = useRef<number>(undefined);
  const saving = useRef<Promise<void>>(Promise.resolve());

  useEffect(() => () => clearTimeout(timer.current), []);

  useEffect(() => preloadImage(isMobile ? images.analysisMo : images.analysis), [isMobile]);

  const saveSurvey = (data: Record<string, string>) => {
    saving.current = saving.current
        .then(() =>
            axios.post<{ ID: number }>(
                `${import.meta.env.VITE_APP_API_URL || 'http://localhost:8000'}/survey`,
                {
                    ...data,
                    ID: surveyId.current,
                    ChannelType: isKiosk ? 'KIOSK' : 'WEB',
                }
            )
        )
        .then(({ data: res }) => {
            surveyId.current = res.ID;
        })
        .catch((e) => console.error(e));
  };

  const onSelect = (optionIndex: number) => {
    const next = [...selected.slice(0, index), optionIndex];
    setSelected(next);

    const data: Record<string, string> = {
      ...Object.fromEntries(
        questionList.map((q, i) => [`Q${i + 1}`, q.options[next[i]]?.value ?? '']),
      ),
      Result: '',
    };

    clearTimeout(timer.current);
    if (index < total - 1) {
      saveSurvey(data);
      timer.current = setTimeout(() => setIndex(index + 1), NEXT_DELAY);
      return;
    }

    // 결과 계산
    const area = questionList[0].options[next[0]].value;
    const traits = next.slice(1).map((s, i) => questionList[i + 1].options[s].check);
    const activeCount = traits.filter((t) => t === 'active').length;
    // ★결과 유형 (1~8)
    //  설문별 타입 추가
    const resultType = TYPE_TABLE[area][activeCount >= 2 ? 'active' : 'calm'];
    data.Result = 'TYPE0' + resultType;
    preloadImage(typeResultImg(resultType, isMobile));
    saveSurvey(data);
    timer.current = setTimeout(() => navigate(`/analyze?type=${resultType}`), NEXT_DELAY);

  };

  const onPrev = () => {
    if (index === 0) return;
    clearTimeout(timer.current);
    setIndex(index - 1);
  };
  


  return (
      <main>
          <section className='wrap quest_wrap'>
              <div className='progress_box'>
                  <div>
                      <span className='step'>{pad(step)}</span>
                      <span className='all_step'> / {pad(total)}</span>
                  </div>
                  <div className='paws_box'>
                      {questionList.map((q, i) => (
                          <span
                              key={q.id}
                              className={clsx('paw', i < step && 'active')}
                          />
                      ))}
                  </div>
              </div>
              <div className='quest_content_box'>
                  <div>
                      <div className='quest_badge'>{question.badge}</div>
                      <h2 className='quest_title'>{question.title}</h2>
                      <p className='quest_des'>{question.des}</p>
                  </div>
                  <img
                      className='quest_img'
                      src={images[`q${step}` as keyof typeof images]}
                      alt='dog'
                  />
              </div>

              <ul className='quest_option_box'>
                  {question.options.map((o, i) => (
                      <li key={i} className='quest_option'>
                          <button
                              type='button'
                              className={clsx(
                                  LABELS[i],
                                  'quest_list',
                                  selected[index] === i && 'active'
                              )}
                              onClick={() => onSelect(i)}
                          >
                              <div className={clsx('quest_option_type')}>
                                  {LABELS[i]}
                              </div>
                              <div className={clsx('quest_option_content')}>
                                  <span className='quest_option_label'>
                                      {o.label}
                                  </span>
                                  <span className='quest_option_sub_label'>
                                      {o.subLabel}
                                  </span>
                              </div>
                          </button>
                      </li>
                  ))}
              </ul>
          </section>
          <div className="quest_footer">
            <button type='button' className={clsx('quest_footer_button', step == 1 && 'none')} onClick={onPrev}>
                <img src={images.prevArrow} alt='prev' />
                <span>이전</span>
            </button>
          </div>
      </main>
  );
}
