import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import TableRowId from '@admin/common/components/table/partials/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/table/partials/tableRow/TableRowImageWithText';
import UsersIcon from '@/images/icons/users.svg';
import TableRowActiveBadge from '@admin/common/components/table/partials/tableRow/TableRowActiveBadge';
import TableActions from '@admin/common/components/table/partials/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { CurrencyListFiltersInterface } from '@admin/modules/currency/interfaces/CurrencyListFiltersInterface';
import { CurrencyListItemInterface } from '@admin/modules/currency/interfaces/CurrencyListItemInterface';
import Badge from '@admin/common/components/Badge';
import RangeFilter from '@admin/common/components/table/partials/filters/RangeFilter';


const CurrencyListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<CurrencyListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      roundingPrecisionFrom: getCurrentParam('roundingPrecisionFrom', (value) => Number(value)),
      roundingPrecisionTo: getCurrentParam('roundingPrecisionTo', (value) => Number(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<CurrencyListItemInterface>({
    endpoint: 'admin/currencies',
    filters,
    setFilters,
    defaultSort,
  });


  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item: CurrencyListItemInterface) => {
    const { id, name, symbol, code, roundingPrecision } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name,
      symbol,
      code,
      roundingPrecision: (
        <Badge variant="info">
          <strong>{roundingPrecision}</strong>
        </Badge>
      ),
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/currencies/${id}`)} />,
    });
  });

  const columns: TableColumn[]  = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'symbol', label: 'Symbol', sortable: true },
    { orderBy: 'code', label: 'Kod', sortable: true },
    { orderBy: 'roundingPrecision', label: 'Zaokrąglenie', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalFilters: ReactElement[] = [
    <RangeFilter filters={filters} setFilters={setFilters} label="Zaokrąglenie" nameFilter="roundingPrecision" />,
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Waluty" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<CurrencyListItemInterface, CurrencyListFiltersInterface>
      filters={filters}
      setFilters={setFilters}
      defaultFilters={defaultFilters}
      sort={sort}
      setSort={setSort}
      columns={columns}
      items={data}
      pagination={pagination}
      additionalToolbarContent={additionalToolbarContent}
      additionalFilters={additionalFilters}
    />
  );
}

export default CurrencyListPage;
