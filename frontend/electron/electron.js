const { app, BrowserWindow, globalShortcut, ipcMain } = require('electron');
const fs = require('fs');
const path = require('path');

// 환경 변수 또는 NODE_ENV로 개발 모드 확인
const isDev =
  process.env.IS_DEV === 'true' || process.env.NODE_ENV === 'development';

let mainWindow;

const AutoLaunch = require('auto-launch');

const autoLauncher = new AutoLaunch({
  name: 'stampearth_beam', // 앱 이름으로 변경

  path: app.getPath('exe'), // 실행 파일 경로
});

async function enableAutoLaunch() {
  try {
    // 개발 환경에서는 자동 시작 설정 안함

    if (!app.isPackaged) {
      console.log('개발 환경에서는 자동 시작을 설정하지 않습니다.');

      return;
    }

    const isEnabled = await autoLauncher.isEnabled();

    if (!isEnabled) {
      await autoLauncher.enable();

      console.log('자동 시작이 활성화되었습니다.');
    } else {
      console.log('자동 시작이 이미 활성화되어 있습니다.');
    }
  } catch (error) {
    console.error('자동 시작 설정 중 오류:', error);
  }
}

async function createWindow() {
  mainWindow = new BrowserWindow({
    width: 1080,
    height: 1920,
    fullscreen: !isDev, // 개발 모드에서는 전체화면 해제
    kiosk: !isDev, // 개발 모드에서는 키오스크 모드 해제
    frame: isDev, // 개발 모드에서는 프레임 표시
    autoHideMenuBar: !isDev, // 개발 모드에서는 메뉴바 표시
    alwaysOnTop: !isDev, // 개발 모드에서는 항상 최상위 해제
    closable: true, // 개발 모드에서는 닫기 버튼 활성화
    minimizable: isDev, // 개발 모드에서는 최소화 버튼 활성화
    maximizable: isDev, // 개발 모드에서는 최대화 버튼 활성화
    resizable: isDev, // 개발 모드에서는 크기 조절 활성화
    movable: isDev, // 개발 모드에서는 창 이동 활성화
    webPreferences: {
      webSecurity: false, // 개발 중에만 사용
      nodeIntegration: false, // 보안을 위해 false로 설정
      contextIsolation: true, // 보안을 위해 true로 설정
      preload: path.join(__dirname, 'preload.js'),
    },
  });

  try {
    if (isDev) {
      // 개발 환경: Vite 개발 서버에 연결
      await mainWindow.loadURL('http://localhost:3000/');
      // 개발자 도구 자동 열기
      mainWindow.webContents.openDevTools();
    } else {
      // 프로덕션 환경: 빌드된 파일 로드
      const indexPath = path.join(__dirname, '../dist/index.html');
      await mainWindow.loadFile(indexPath);
      // mainWindow.webContents.openDevTools();
      // 프로덕션에서 개발자 도구 비활성화
      mainWindow.webContents.on('devtools-opened', () => {
        mainWindow.webContents.closeDevTools();
      });
    }
  } catch (error) {
    console.error('Failed to load window:', error);
    // 에러 발생 시 대체 콘텐츠 표시
    mainWindow.loadURL(`data:text/html,
      <h1>Error loading application</h1>
      <p>${error.message}</p>
    `);
  }

  // 새 창 열기 방지 (new-window 이벤트는 deprecated, 대신 setWindowOpenHandler 사용)
  mainWindow.webContents.setWindowOpenHandler(() => {
    return { action: 'deny' };
  });

  // 컨텍스트 메뉴(우클릭 메뉴) 비활성화
  mainWindow.webContents.on('context-menu', (e) => {
    e.preventDefault();
  });

  // 윈도우가 닫히면 참조 해제
  mainWindow.on('closed', () => {
    mainWindow = null;
  });
}

// 앱이 준비되면 윈도우 생성
app.whenReady().then(async () => {
  await createWindow();
  enableAutoLaunch();

  // 프로덕션 환경에서만 시스템 단축키 비활성화
  //if (!isDev) {
  // Alt+F4 비활성화
  globalShortcut.register('Alt+F4', () => {
    return false;
  });

  // Alt+Tab 비활성화
  globalShortcut.register('Alt+Tab', () => {
    return false;
  });

  // Windows 키 비활성화
  globalShortcut.register('Super', () => {
    return false;
  });

  // Ctrl+Alt+Delete 비활성화 (제한적)
  globalShortcut.register('Ctrl+Alt+Delete', () => {
    return false;
  });
  //}

  // ESC 키로 종료 (개발/테스트용)
  globalShortcut.register('Escape', () => {
    app.quit();
  });

  // 관리자 모드 진입 (비밀번호 입력 후)
  globalShortcut.register('Ctrl+Shift+Q', () => {
    if (mainWindow) {
      mainWindow.webContents.send('show-admin-panel');
    }
  });
});

ipcMain.on('window-close', async (event, action) => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

// macOS를 제외한 모든 윈도우가 닫히면 앱 종료
app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

// macOS에서 앱 아이콘 클릭 시 윈도우 재생성
app.on('activate', async () => {
  if (BrowserWindow.getAllWindows().length === 0) {
    await createWindow();
  }
});

// 앱 종료 시 단축키 해제
app.on('will-quit', () => {
  globalShortcut.unregisterAll();
});

// 에러 핸들링
process.on('uncaughtException', (error) => {
  console.error('Uncaught Exception:', error);
});

process.on('unhandledRejection', (error) => {
  console.error('Unhandled Rejection:', error);
});


// 비디오 경로 반환
ipcMain.handle('get-video-path', (event, fileName) => {
  const fullPath = path.join('C:', 'philakorea', fileName);

  // 파일 존재 확인
  if (fs.existsSync(fullPath)) {
    // file:// 프로토콜로 반환
    return `file:///${fullPath.replace(/\\/g, '/')}`;
  }
  return null;
});

// 파일 존재 여부 확인
ipcMain.handle('check-file-exists', (event, filePath) => {
  return fs.existsSync(filePath);
});