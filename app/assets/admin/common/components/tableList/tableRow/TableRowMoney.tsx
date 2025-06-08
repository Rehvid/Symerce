import { FC } from 'react';
import clsx from 'clsx';

interface TableRowMoneyProps {
    amount?: number | string;
    symbol?: string;
    className?: string;
}

const TableRowMoney: FC<TableRowMoneyProps> = ({ amount, symbol, className }) => {
    const hasValue = amount !== undefined && symbol;

    return (
        <strong
            className={clsx('font-semibold text-gray-800', className)}
        >
            {hasValue ? `${amount} ${symbol}` : '—'}
        </strong>
    );
};

export default TableRowMoney;
