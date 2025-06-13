import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { SettingTableFilters } from '@admin/modules/setting/interfaces/SettingTableFilters';
import { useListData } from '@admin/common/hooks/list/useListData';
import { SettingListItem } from '@admin/modules/setting/interfaces/SettingListItem';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableRowEditAction from '@admin/common/components/tableList/tableRow/TableRowEditAction';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';

const SettingList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();

    const [filters, setFilters] = useState<SettingTableFilters>(
        filterEmptyValues({
            ...defaultFilters,
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
            search: getCurrentParam('search', (value) => String(value)),
        }) as SettingTableFilters,
    );

    const { items, pagination, isLoading, sort, setSort } = useListData<SettingListItem, SettingTableFilters>({
        endpoint: 'admin/settings',
        filters,
        setFilters,
        defaultSort,
    });

    const rowData = items.map((item: SettingListItem) => [
        <TableRowId id={item.id} />,
        item.name,
        item.type,
        <TableRowActive isActive={item.isActive} />,
        <TableRowEditAction to={`${item.id}/edit`} />,
    ]);

    const columns: TableColumn[] = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'settingType', label: 'Typ', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista ustawień" totalItems={pagination?.totalItems} createHref={null} />
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

export default SettingList;
