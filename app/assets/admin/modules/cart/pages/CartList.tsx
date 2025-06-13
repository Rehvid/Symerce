import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowDetailAction from '@admin/common/components/tableList/tableRow/TableRowDetailAction';
import Link from '@admin/common/components/Link';
import { CartListItem } from '@admin/modules/cart/interfaces/CartListItem';
import { CartTableFilters } from '@admin/modules/cart/interfaces/CartTableFilters';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';

const CartList = () => {
  const { defaultFilters, defaultSort } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<CartTableFilters>(
    filterEmptyValues({
      ...defaultFilters,
    }) as CartTableFilters,
  );

  const { items, pagination, isLoading, sort, setSort } = useListData<CartListItem, CartTableFilters>({
    endpoint: 'admin/carts',
    filters,
    setFilters,
    defaultSort,
  });

  const rowData = items.map((item: CartListItem) => [
      <TableRowId id={item.id} />,
      item.orderId ? <Link to={`/admin/orders/${item.orderId}/details`} >Zamówienie</Link> : '-',
      item.customer,
      item.total,
      item.createdAt,
      item.updatedAt,
      item.expiresAt,
      <TableRowDetailAction to={`${item.id}/details`} />
  ]);

  const columns: TableColumn[]  = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'orderId', label: 'Zamówienie', sortable: true },
    { orderBy: 'customer', label: 'Klient', sortable: true },
    { orderBy: 'total', label: 'Total', sortable: true },
    { orderBy: 'createdAt', label: 'Utworzono', sortable: true },
    { orderBy: 'updatedAt', label: 'Ostatnia aktualizacja', sortable: true },
    { orderBy: 'expiresAt', label: 'Koszyk wygasa', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  return (
      <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
          <TableToolbar>
              <TableToolbarActions title="Lista koszyków" totalItems={pagination?.totalItems} createHref={null} />
              <TableToolbarFilters
                  sort={sort}
                  setSort={setSort}
                  filters={filters}
                  setFilters={setFilters}
                  defaultFilters={defaultFilters}
                  useSearch={false}
              >
                  <ActiveFilter setFilters={setFilters} filters={filters} />
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

export default CartList;
