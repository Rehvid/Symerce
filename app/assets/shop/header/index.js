import { UserModalToggle } from '@/shop/header/components/UserModalToggle';
import MenuModalToggle from '@/shop/header/components/MenuModalToggle';
import { renderOverlay } from '@/shop/overlayManager';
import { createRoot } from 'react-dom/client';
import CartComponent from '@/shop/header/components/CartComponent';

export const mountHeader = () => {
    mountUserModalToggle();
    mountMenuModal();
    mountCartHeader();
};

const mountUserModalToggle = () => {
    document.querySelector('.react-user-modal-toggle')?.addEventListener('click', () => {
        renderOverlay(<UserModalToggle />);
    });
};

const mountCartHeader = () => {
    const element = document.querySelector('.react-header-cart');
    if (element) {
        createRoot(element).render(<CartComponent href={element.dataset.href} />);
    }
}

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
