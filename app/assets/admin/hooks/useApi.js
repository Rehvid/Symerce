import { useContext } from 'react';
import { ApiContext } from '@/admin/store/ApiContext';

export const useApi = () => useContext(ApiContext);
