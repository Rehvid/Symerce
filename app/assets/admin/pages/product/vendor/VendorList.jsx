import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';

const VendorList = () => {
  const currentFilters = new URLSearchParams(location.search);
  const [filters, setFilters] = useState({
    limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
    page: Number(currentFilters.get('page')) || 1,
  });

  const {
    items,
    pagination,
    isLoading,
    fetchItems,
    removeItem,
  } = useListData('admin/vendors', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }

  const data = items.map((item) => {
    return Object.values({
      id: item.id,
      name: item.name,
      actions: <TableActions editPath={`${item.id}/edit`} onDelete={() => removeItem(`admin/vendors/${item.id}`)}  />,
    });
  });

  return (
    <>
      <PageHeader title={'Producent'}>
        <Breadcrumb />
      </PageHeader>

      <DataTable
        title="Producenci"
        filters={filters}
        setFilters={setFilters}
        columns={['Id', 'Name', 'Actions']}
        items={data}
        pagination={pagination}
        additionalFilters={[PaginationFilter]}
        actionButtons={<TableToolbarButtons/>}
      />
    </>
  )
}

export default VendorList;
