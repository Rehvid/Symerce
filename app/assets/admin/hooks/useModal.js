import { ModalContext } from '@/admin/store/ModalContext';
import { useContext } from 'react';

export const useModal = () => useContext(ModalContext);
