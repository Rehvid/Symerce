import { useEffect, useState } from 'react';
import { clearOverlay } from '@/shop/overlayManager';

export const useClickToggleBySelector = (initialOpenState, triggerTarget, handler, searchInDom = true) => {
  const [open, setOpen] = useState(initialOpenState);

  useEffect(() => {
    let element = triggerTarget;

    if (searchInDom) {
      element = document.querySelector(triggerTarget);
    }

    if (!element) return;

    element.addEventListener('click', (e) => handler(e));

    return () => element.removeEventListener('click', (e) => handler(e));
  }, []);

  const openModal = () => setOpen(true);

  const toggleOpen = () => setOpen(value => !value);

  const closeModal = () => {
    clearOverlay();
    setOpen(false);
  }

  return { open, closeModal, openModal, toggleOpen }
}
