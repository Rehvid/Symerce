import React, { FC, useState } from 'react';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';

interface TableWithLoadingSkeletonProps {
    isLoading: boolean;
    filtersLimit: number;
    children: React.ReactNode;
}

const TableWithLoadingSkeleton: FC<TableWithLoadingSkeletonProps> = ({isLoading, filtersLimit, children}) => {
    const [isComponentInit, setIsComponentInit] = useState<boolean>(false);

    if (!isComponentInit && isLoading) {
        return <TableSkeleton rowsCount={filtersLimit} />
    }

    if (!isComponentInit) {
        setIsComponentInit(true);
    }

    return children;
}

export default TableWithLoadingSkeleton;
