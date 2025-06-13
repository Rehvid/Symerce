import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import Link from '@admin/common/components/Link';
import EyeIcon from '@/images/icons/eye.svg';
import { AttributeTableFilters } from '@admin/modules/attribute/interfaces/AttributeTableFilters';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';
import { AttributeListItem } from '@admin/modules/attribute/interfaces/AttributeListItem';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';

const AttributeList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState<AttributeTableFilters>(
        filterEmptyValues({
            ...defaultFilters,
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
            search: getCurrentParam('search', (value) => String(value)),
        }) as AttributeTableFilters,
    );

    const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<
        AttributeListItem,
        AttributeTableFilters
    >({
        endpoint: 'admin/attributes',
        filters,
        setFilters,
        defaultSort,
    });

    const renderTableActions = (item: AttributeListItem): ReactElement => (
        <TableActions id={item.id} onDelete={() => removeItem(`admin/attributes/${item.id}`)}>
            <Link
                to={`${item.id}/values`}
                additionalClasses="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 hover:bg-primary hover:text-white transition-colors text-gray-500"
            >
                <EyeIcon className="w-5 h-5" />
            </Link>
        </TableActions>
    );

    const rowData = items.map((item: AttributeListItem) => [
        <TableRowId id={item.id} />,
        item.name,
        <TableRowActive isActive={item.isActive} />,
        renderTableActions(item),
    ]);

    const columns: TableColumn[] = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista atrybutów" totalItems={pagination?.totalItems} />
                <TableToolbarFilters
                    sort={sort}
                    setSort={setSort}
                    filters={filters}
                    setFilters={setFilters}
                    defaultFilters={defaultFilters}
                >
                    <ActiveFilter setFilters={setFilters} filters={filters} />
                </TableToolbarFilters>
            </TableToolbar>
            <TableWrapper isLoading={isLoading}>
                <TableHead sort={sort} setSort={setSort} columns={columns} />
                <TableBody data={rowData} filters={filters} pagination={pagination as Pagination} />
            </TableWrapper>
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination as Pagination} />
        </TableWithLoadingSkeleton>
    );
};

export default AttributeList;
