import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import UsersIcon from '@/images/icons/users.svg';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import { UserListItem } from '@admin/modules/user/interfaces/UserListItem';
import { TableColumn } from '@admin/common/types/tableColumn';
import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { UserTableFilters } from '@admin/modules/user/interfaces/UserTableFilters';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import RangeFilter from '@admin/common/components/tableList/filters/RangeFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';

const UserList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<UserTableFilters>(
    filterEmptyValues({
      ...defaultFilters,
        isActive: getCurrentParam('isActive', (value) => Boolean(value)),
        search: getCurrentParam('search', (value) => String(value)),
    }) as UserTableFilters,
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<UserListItem, UserTableFilters>({
    endpoint: 'admin/users',
    filters,
    setFilters,
    defaultSort,
  });

  const rowData = items.map((item: UserListItem) => [
       <TableRowId id={item.id} />,
        <TableRowImageWithText
            imagePath={item.imagePath}
            text={item.fullName}
            defaultIcon={<UsersIcon className="text-primary mx-auto" />}
        />,
        item.email,
        <TableRowActive isActive={item.isActive} />,
         <TableActions id={item.id} onDelete={() => removeItem(`admin/users/${item.id}`)} />,
  ]);

  const columns: TableColumn[]  = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'fullName', label: 'Użytkownik' },
    { orderBy: 'email', label: 'Email', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  return (
      <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
          <TableToolbar>
              <TableToolbarActions title="Lista użytkowników" totalItems={pagination?.totalItems} />
              <TableToolbarFilters sort={sort} setSort={setSort} filters={filters} setFilters={setFilters} defaultFilters={defaultFilters}>
                  <ActiveFilter setFilters={setFilters} filters={filters} />
                  <RangeFilter filters={filters} setFilters={setFilters} label="Opłata" nameFilter="fee" />
              </TableToolbarFilters>
          </TableToolbar>
          <TableWrapper isLoading={isLoading}>
              <TableHead sort={sort} setSort={setSort} columns={columns} />
              <TableBody
                  data={rowData}
                  filters={filters}
                  pagination={pagination as Pagination}
              />
          </TableWrapper>
          <TablePagination
              filters={filters}
              setFilters={setFilters}
              pagination={pagination as Pagination}
          />
      </TableWithLoadingSkeleton>
  );
}


export default UserList;
