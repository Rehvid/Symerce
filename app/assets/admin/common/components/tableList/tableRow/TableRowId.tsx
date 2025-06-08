import { useNavigate } from 'react-router-dom';
import { FC } from 'react';

interface TableRowIdProps {
    id: string | number;
}

const TableRowId: FC<TableRowIdProps> = ({ id }) => {
    const navigate = useNavigate();

    const handleClick = () => {
        navigate(`${id}/edit`);
    };

    return (
        <span
            className="font-bold cursor-pointer text-primary hover:text-primary-active"
            onClick={handleClick}
            title={`Edytuj #${id}`}
        >
      #{id}
    </span>
    );
};

export default TableRowId;
