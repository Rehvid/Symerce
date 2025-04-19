import TableRowDeleteAction from '@/admin/components/table/Partials/TableRow/TableRowDeleteAction';
import TableRowEditAction from '@/admin/components/table/Partials/TableRow/TableRowEditAction';

const TableActions = ({ id, onDelete, children }) => {
  return (
    <div className="flex gap-2 items-start">
      <TableRowDeleteAction onClick={onDelete} />
      <TableRowEditAction to={`${id}/edit`} />
      {children}
    </div>
  );
};

export default TableActions;
