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

const DeliveryTimeList = () => {
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
  } = useListData('admin/delivery-time', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }


  const data = items.map((item) => {
    return Object.values({
      id: item.id,
      label: item.label,
      minDays: item.minDays,
      maxDays: item.maxDays,
      type: item.type,
      actions: <TableActions editPath={`${item.id}/edit`} onDelete={() => removeItem(`admin/delivery-time/${item.id}`)}  />,
    });
  });

  return (
    <>
      <PageHeader title={'Czasy Dostawy'}>
        <Breadcrumb />
      </PageHeader>

      <DataTable
        title="Czasy"
        filters={filters}
        setFilters={setFilters}
        columns={['Id', 'Label', 'MinDays', 'MaxDays', 'Type', 'Actions']}
        items={data}
        pagination={pagination}
        additionalFilters={[PaginationFilter]}
        actionButtons={<TableToolbarButtons/>}
      />
    </>
  )
}

export default DeliveryTimeList;
