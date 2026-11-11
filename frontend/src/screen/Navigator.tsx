import { Routes, Route, Outlet, Navigate, useNavigate, useLocation, matchPath } from 'react-router-dom';
import { useTypeCookie } from 'shared/hooks/useTypeCookie';
import { BrowserRouter as Router } from 'react-router-dom';
import { useMemo, type ReactNode } from 'react';
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

const REDIRECT_TO_PRESC = ['/', '/quest', '/type_result'];

const Layout = () => {
  const location = useLocation();
  const { pathname } = location;
  const current = routes.find((r) => matchPath(r.path, pathname));
  const { left, reset } = useIdleTimer(pathname !== '/');
  const { cookie } = useTypeCookie();
  const hasType = /^[1-8]$/.test(String(cookie.type));

  const redirectType = useMemo(
    () =>
      hasType && REDIRECT_TO_PRESC.includes(pathname) && !location.state?.fromAnalyze
        ? cookie.type
        : null,
    [location.key],
  );

  if (redirectType) {
    return <Navigate to={`/presc?type=${redirectType}`} replace />;
  }

  return (
    <>
        <Header
          title={current?.title}
          type={current?.type}
          hideHome={pathname === '/presc' && hasType}
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

const RootRouter = () => {
  return (
      <Router>
        <Navigator />
      </Router>
  );
};

export default RootRouter;
