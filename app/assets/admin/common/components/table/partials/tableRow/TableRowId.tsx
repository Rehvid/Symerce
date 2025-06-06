import { useNavigate } from 'react-router-dom';

const TableRowId = ({ id }) => {
    const navigate = useNavigate();

    return (
        <span
            className="font-bold cursor-pointer text-primary hover:text-primary-active"
            onClick={() => navigate(`${id}/edit`)}
        >
            #{id}
        </span>
    );
};

export default TableRowId;
