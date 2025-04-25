import { useContext } from 'react';
import { DataContext } from '@/admin/store/DataContext';

export const useData = () => useContext(DataContext);
