import { createRoot } from 'react-dom/client';
import '../styles/app.css';
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import App from './app';
import { StrictMode } from 'react';

const container = document.getElementById('app');
const root = createRoot(container);
root.render(
  <StrictMode>
    <App />
  </StrictMode>
);
