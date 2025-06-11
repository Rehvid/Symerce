import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, {  useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { useParams } from 'react-router-dom';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableActions from '@admin/common/components/tableList/TableActions';
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
import { AttributeValueListItem } from '@admin/modules/attributeValue/interfaces/AttributeValueListItem';
import { AttributeValueTableFilters } from '@admin/modules/attributeValue/interfaces/AttributeValueTableFilters';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';

const AttributeValueList = () => {
  const params = useParams();
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<AttributeTableFilters>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }) as AttributeTableFilters,
  );

    const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<AttributeValueListItem,AttributeValueTableFilters>({
    endpoint: `admin/attributes/${params.attributeId}/values`,
    filters,
    setFilters,
    defaultSort,
  });

  const rowData = items.map((item: AttributeValueListItem) => [
       <TableRowId id={item.id} />,
        item.value,
        <TableActions
          id={item.id}
          onDelete={() => removeItem(`admin/attributes/${params.attributeId}/values/${item.id}`)}
        />,
  ]);

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'value', label: 'Wartość', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];



    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista atrybutów" totalItems={pagination?.totalItems} />
                <TableToolbarFilters sort={sort} setSort={setSort} filters={filters} setFilters={setFilters} defaultFilters={defaultFilters}>
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

export default AttributeValueList;
