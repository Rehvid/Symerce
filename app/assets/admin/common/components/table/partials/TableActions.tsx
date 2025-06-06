import TableRowDeleteAction from '@admin/common/components/table/partials/tableRow/TableRowDeleteAction';
import TableRowEditAction from '@admin/common/components/table/partials/tableRow/TableRowEditAction';

const TableActions = ({ id, onDelete, children }) => {
    return (
        <div className="flex gap-2 items-center">
            <TableRowDeleteAction onClick={onDelete} />
            <TableRowEditAction to={`${id}/edit`} />
            {children}
        </div>
    );
};

export default TableActions;
