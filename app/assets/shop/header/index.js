import { createRoot } from 'react-dom/client';
import { UserModalToggle } from '@/shop/header/UserModalToggle';
import Submenu from '@/shop/header/Submenu';
import MenuModalToggle from '@/shop/header/MenuModalToggle';
import { renderOverlay } from '@/shop/overlayManager';

export const mountHeader = () => {
    mountUserModalToggle();
    mountMenuModal();
};

const mountUserModalToggle = () => {
    document.querySelector('.react-user-modal-toggle')?.addEventListener('click', () => {
        renderOverlay(<UserModalToggle />);
    });
};

const mountMenuModal = () => {
    const reactMenuModalElement = document.querySelector('.react-menu-modal-toggle');

    if (!reactMenuModalElement) {
        return;
    }

    const dataMenu = reactMenuModalElement.getAttribute('data-menu');
    let items = [];

    try {
        items = JSON.parse(dataMenu);
    } catch (e) {
        console.error(e.message);
        console.error('Cannot parse submenu data!');
    }

    reactMenuModalElement.addEventListener('click', () => {
        renderOverlay(<MenuModalToggle items={items} />);
    });
};
