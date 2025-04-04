import { useContext } from 'react';
import { AuthContext } from '@/admin/store/AuthContext';

export const useAuth = () => useContext(AuthContext);
