import clsx from 'clsx';

const TableRowActive = ({ isActive }: { isActive: boolean }) => {
    const text = isActive ? 'Aktywny' : 'Nieaktywny';

    return (
        <span
            className={clsx(
                'inline-flex items-center px-2.5 py-1 text-sm font-medium rounded-full',
                isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
            )}
        >
            {text}
        </span>
    );
};

export default TableRowActive;
