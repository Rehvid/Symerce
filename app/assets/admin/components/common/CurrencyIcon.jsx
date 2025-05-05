import { useData } from '@/admin/hooks/useData';

const CurrencyIcon = () => {
    const { currency } = useData();
    const symbol = currency?.symbol;
    if (!currency || !symbol) {
        return null;
    }

    return <span className="h-[24px] max-w-[24px] w-full text-gray-500 block text-lg px-2">{symbol}</span>;
};

export default CurrencyIcon;
