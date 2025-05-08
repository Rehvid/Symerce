import { createRoot } from 'react-dom/client';

let container = null;
let root = null;

export const renderOverlay = (component) => {
  if (!container) {
    container = document.createElement('div');
    container.id = 'global-react-overlay';
    document.body.appendChild(container);
    root = createRoot(container);
  }

  root?.render(component);
};

export const clearOverlay = () => {
  if (root && container) {
    root.render(null);
  }
}
