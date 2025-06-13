import { createRoot } from 'react-dom/client';
import '@/admin/styles/app.css';
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'react-datepicker/dist/react-datepicker.css';
import App from './App';

const container = document.getElementById('app');
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}
