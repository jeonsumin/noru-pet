import arrow from './arrow.svg';
import logo from './logo.png';
import main from './main.png';
import paw from './paw.svg';
import boneBadge from './bone_badge.png'
import q1 from './q1.png'
import q2 from './q2.png'
import q3 from './q3.png'
import q4 from './q4.png'
import prevArrow from './prev_arrow.svg';
import analysis from './analysis.gif';
import analysisMo from './analysis_mo.gif';
import goods from './goods.png'
import qr_1 from './qr_type_1.svg';
import qr_2 from './qr_type_2.svg';
import qr_3 from './qr_type_3.svg';
import qr_4 from './qr_type_4.svg';
import qr_5 from './qr_type_5.svg';
import qr_6 from './qr_type_6.svg';
import qr_7 from './qr_type_7.svg';
import qr_8 from './qr_type_8.svg';


export const images = {
    arrow,
    logo,
    main,
    paw,
    boneBadge,
    q1, q2, q3, q4,
    prevArrow,
    analysis,
    analysisMo,
    qr_1,
    qr_2,
    qr_3,
    qr_4,
    qr_5,
    qr_6,
    qr_7,
    qr_8,
    goods
};

const typeResultImgs = import.meta.glob<string>('./type_result_*.png', { eager: true, import: 'default' });

export const typeResultImg = (type: number, mobile: boolean) =>
    typeResultImgs[`./type_result_${mobile ? 'mo_' : ''}${type}.png`];

export const preloadImage = (src: string) => {
    new Image().src = src;
};
