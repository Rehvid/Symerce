import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import Badge from '@/admin/components/common/Badge';

const CarrierList = () => {
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
  } = useListData('admin/carriers', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }

  const activeBadge = (item) => {
    const variant = item.isActive ? 'success' : 'error';
    const text = item.isActive ? 'Aktywny' : 'Nieaktywny';

    return <Badge variant={variant} >{text}</Badge>
  }


  const data = items.map((item) => {
    return Object.values({
      id: item.id,
      name: item.name,
      active: activeBadge(item),
      fee: item.fee,
      actions: <TableActions editPath={`${item.id}/edit`} onDelete={() => removeItem(`admin/carriers/${item.id}`)}  />,
    });
  });

  return (
    <>
      <PageHeader title={'Dostawcy'}>
        <Breadcrumb />
      </PageHeader>

      <DataTable
        title="Twoi Dostawcy"
        filters={filters}
        setFilters={setFilters}
        columns={['Id', 'Name', 'Active', 'Fee', 'Actions']}
        items={data}
        pagination={pagination}
        additionalFilters={[PaginationFilter]}
        actionButtons={<TableToolbarButtons/>}
      />
    </>
  )
}

export default CarrierList;
