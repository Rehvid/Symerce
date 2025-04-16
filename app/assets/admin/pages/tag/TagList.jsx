import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';

const TagList = () => {
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
  } = useListData('admin/tags', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }

  const data = items.map((item) => {
    return Object.values({
      id: item.id,
      name: item.name,
      actions: <TableActions editPath={`${item.id}/edit`} onDelete={() => removeItem(`admin/tags/${item.id}`)}  />,
    });
  });

  return (
    <>
      <PageHeader title={'Tagi'}>
        <Breadcrumb />
      </PageHeader>

      <DataTable
        title="Twoje tagi"
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
export default TagList;
