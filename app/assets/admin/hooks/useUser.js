import { useContext } from 'react';
import { UserContext } from '@/admin/store/UserContext';

export const useUser = () => useContext(UserContext);
