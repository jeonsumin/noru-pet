import { createRoot } from 'react-dom/client';
import { CookiesProvider } from 'react-cookie';
import Navigator from './screen/Navigator';
import 'shared/styles/global.css'

const rootElement = document.getElementById('root');
if (!rootElement) throw new Error('Failed to find the root element');

const root = createRoot(rootElement);

root.render(
    <CookiesProvider>
        <Navigator />
    </CookiesProvider>
);
