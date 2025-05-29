import useListDefaultQueryParams from '@admin/shared/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/utils/helper';
import { useListData } from '@admin/shared/hooks/list/useListData';
import TableSkeleton from '@admin/components/skeleton/TableSkeleton';
import TableRowId from '@admin/components/table/Partials/TableRow/TableRowId';
import TableRowImageWithText from '@admin/components/table/Partials/TableRow/TableRowImageWithText';
import UsersIcon from '@/images/icons/users.svg';
import TableRowActiveBadge from '@admin/components/table/Partials/TableRow/TableRowActiveBadge';
import TableActions from '@admin/components/table/Partials/TableActions';
import { TableColumn } from '@admin/shared/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/components/ListHeader';
import TableToolbarButtons from '@admin/components/table/Partials/TableToolbarButtons';
import DataTable from '@admin/shared/components/table/DataTable';
import { CurrencyListFiltersInterface } from '@admin/modules/currency/interfaces/CurrencyListFiltersInterface';
import { CurrencyListItemInterface } from '@admin/modules/currency/interfaces/CurrencyListItemInterface';
import Badge from '@admin/components/common/Badge';
import RangeFilter from '@admin/components/table/Filters/RangeFilter';


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
