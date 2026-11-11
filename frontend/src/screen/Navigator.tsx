import {
    Routes,
    Route,
    Outlet,
    useNavigate,
    useLocation,
    matchPath,
    HashRouter,
} from 'react-router-dom';
import { BrowserRouter } from 'react-router-dom';
import { isKiosk } from 'shared/isKiosk';
import { type ReactNode } from 'react';
import { Header, type HeaderProps } from 'shared/ui/Header';
import { MainScreen } from './MainScreen';
import { QuestionScreen } from './QuestionScreen';
import { AnalyzeScreen } from './AnalyzeScreen';
import { TypeResultScreen } from './TypeResultScreen';
import { PrescScreen } from './PrescScreen';
import { ResultScreen } from './ResultScreen';
import { Popup } from 'shared/ui/Popup';
import { useIdleTimer } from 'shared/hooks/useIdleTimer';

type AppRoute = HeaderProps & { path: string; element: ReactNode };

const routes: AppRoute[] = [
    {
        path: '/',
        type: 'main',
        element: <MainScreen />,
    },
    {
        path: '/quest',
        title: '펫 안전 검진존',
        type: 'quest',
        element: <QuestionScreen />,
    },
    {
        path: '/analyze',
        type: 'analyze',
        element: <AnalyzeScreen />,
    },
    {
        path: '/type_result',
        type: 'quest',
        title: '검진 결과',
        element: <TypeResultScreen />,
    },
    {
        path: '/presc',
        type: 'quest',
        title: '처방전',
        element: <PrescScreen />,
    },
    {
        path: '/result',
        type: 'quest',
        title: '리워드 받기',
        element: <ResultScreen />,
    },
];

const Layout = () => {
  const { pathname } = useLocation();
  const current = routes.find((r) => matchPath(r.path, pathname));
  const { left, reset } = useIdleTimer(pathname !== '/');

  return (
    <>
        <Header
          title={current?.title}
          type={current?.type}
        />
        <Outlet />
        {left !== null && (
            <Popup
                icon={left}
                title="계속 진행하시겠어요?"
                des={`${left}초 후 처음 화면으로 돌아가요`}
                buttons={[{ text: '계속하기', onClick: reset }]}
            />
        )}
    </>
  );
};

const Navigator = () => {
  const navigate = useNavigate();

  return (
    <>
      <Routes>
        <Route element={<Layout />}>
          {routes.map((r) => (
            <Route key={r.path} path={r.path} element={r.element} />
          ))}
        </Route>
      </Routes>
    </>
  );
};

const Router = isKiosk ? HashRouter : BrowserRouter;

const RootRouter = () => {
  return (
      <Router>
        <Navigator />
      </Router>
  );
};

export default RootRouter;
