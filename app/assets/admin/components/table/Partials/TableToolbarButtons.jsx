import { useNavigate } from 'react-router-dom';
import Button from '@admin/common/components/Button';
import PlusIcon from '@/images/icons/plus.svg';

const TableToolbarButtons = ({ to = 'create', label = 'Dodaj', children }) => {
    const navigate = useNavigate();

    return (
        <div className="flex items-center gap-4">
            <Button
                onClick={() => navigate(to)}
                variant="primary"
                additionalClasses="flex items-center justify-center gap-2 px-4 py-2.5  sm:w-auto w-full"
            >
                <PlusIcon className="w-[24px] h-[24px]" /> {label}
            </Button>
            {children}
        </div>
    );
};

export default TableToolbarButtons;
