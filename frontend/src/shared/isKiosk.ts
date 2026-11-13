declare global {
  interface Window {
    baseAPI?: { closeWindow: (action?: string) => void };
  }
}

export const isKiosk = 'baseAPI' in window;
