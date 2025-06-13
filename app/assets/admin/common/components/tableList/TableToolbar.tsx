import React, { FC } from 'react';

interface TableToolbarProps {
    children: React.ReactNode;
}

const TableToolbar: FC<TableToolbarProps> = ({ children }) => {
    return <>{children}</>;
};

export default TableToolbar;
