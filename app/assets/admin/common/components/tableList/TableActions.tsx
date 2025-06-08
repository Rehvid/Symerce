import TableRowDeleteAction from '@admin/common/components/tableList/tableRow/TableRowDeleteAction';
import TableRowEditAction from '@admin/common/components/tableList/tableRow/TableRowEditAction';
import React from 'react';


interface TableActionsProps {
    id: string | number;
    onDelete: () => void;
    children?: React.ReactNode;
}

const TableActions: React.FC<TableActionsProps> = ({ id, onDelete, children }) => {
    return (
      <div className="flex items-center gap-2">
          <TableRowDeleteAction onClick={onDelete} />
          <TableRowEditAction to={`${id}/edit`} />
          {children}
      </div>
    );
};


export default TableActions;
