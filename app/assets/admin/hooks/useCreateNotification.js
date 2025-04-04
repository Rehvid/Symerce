import { useContext } from 'react';
import { NotificationContext } from '@/admin/store/NotificationContext';

export const useCreateNotification = () => useContext(NotificationContext);
