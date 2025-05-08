import { useEffect, useState } from 'react';
import { clearOverlay } from '@/shop/overlayManager';

export const useClickToggleBySelector = (initialOpenState, triggerTarget, handler, searchInDom = true) => {
    const [open, setOpen] = useState(initialOpenState);

    useEffect(() => {
        let element = triggerTarget;

        if (searchInDom) {
            element = document.querySelector(triggerTarget);
        }

        if (!element) {
            return;
        }

        const listener = (e) => {
            handler(e);
        };

        element.addEventListener('click', listener);

        // eslint-disable-next-line consistent-return
        return () => {
            element.removeEventListener('click', listener);
        };
    }, []);

    const openModal = () => setOpen(true);

    const toggleOpen = () => setOpen((value) => !value);

    const closeModal = () => {
        clearOverlay();
        setOpen(false);
    };

    return { open, closeModal, openModal, toggleOpen };
};
