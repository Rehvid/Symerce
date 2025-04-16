import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import Badge from '@/admin/components/common/Badge';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';

const CurrencyList = () => {
  const currentFilters = new URLSearchParams(location.search);
  const [filters, setFilters] = useState({
    limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
    page: Number(currentFilters.get('page')) || 1,
  });

  const {
    items,
    pagination,
    isLoading,
    removeItem,
  } = useListData('admin/currencies', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }

  const data = items.map((item) => {
    return Object.values({
      id: item.id,
      name: item.name,
      symbol: item.symbol,
      code: item.code,
      roundingPrecision: <Badge variant='info' >{item.roundingPrecision}</Badge>,
      actions: <TableActions editPath={`${item.id}/edit`} onDelete={() => removeItem(`admin/currencies/${item.id}`)}  />,
    });
  });

  return (
    <>
      <PageHeader title={'Waluty'}>
        <Breadcrumb />
      </PageHeader>

      <DataTable
        title="Waluty"
        filters={filters}
        setFilters={setFilters}
        columns={['Id', 'Name', 'Symbol', 'Code', 'Rounding Precision', 'Actions']}
        items={data}
        pagination={pagination}
        additionalFilters={[PaginationFilter]}
        actionButtons={<TableToolbarButtons/>}
      />
    </>
  )
}

export default CurrencyList;
