import { useNavigate } from 'react-router-dom';
import AppButton from '@/admin/components/common/AppButton';
import PlusIcon from '@/images/icons/plus.svg';

const TableToolbarButtons = ({ to = 'create', label = 'Dodaj', children }) => {
  const navigate = useNavigate();

  return (
    <div className="flex items-center gap-4">
      <AppButton
        onClick={() => navigate(to)}
        variant="primary"
        additionalClasses="flex items-center justify-center gap-2 px-4 py-2.5"
      >
        <PlusIcon /> {label}
      </AppButton>
      {children}
    </div>
  );
};

export default TableToolbarButtons;
