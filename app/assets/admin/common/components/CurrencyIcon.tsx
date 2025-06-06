import React from 'react';
import { useAppData } from '@admin/common/context/AppDataContext';

const CurrencyIcon: React.FC = () => {
    const { currency } = useAppData();
    const symbol = currency?.symbol;

    if (!currency || !symbol) {
        return null;
    }

    return (
        <span className="h-[20px] max-w-[20px] w-full text-gray-500 block text-lg px-2">
            {symbol}
        </span>
    );
};

export default CurrencyIcon;
