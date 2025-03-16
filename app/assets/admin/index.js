import { createRoot } from 'react-dom/client';
import '../styles/app.css';
import App from "./app";

const container = document.getElementById('app');
const root = createRoot(container);
root.render(<App />);
