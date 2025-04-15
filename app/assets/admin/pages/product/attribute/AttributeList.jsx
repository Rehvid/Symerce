import { useLocation, useNavigate } from 'react-router-dom';
import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableActions from '@/admin/components/table/Partials/TableActions';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';

const AttributeList = () => {
  const navigate = useNavigate();
  const location = useLocation();
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
  } = useListData('admin/attributes', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }

  const data = items.map((item) => {
    return Object.values({
      id: item.id,
      name: item.name,
      actions: <TableActions editPath={`${item.id}/edit`} onDelete={() => removeItem(`admin/attributes/${item.id}`)} />,
    });
  });

  return (
    <>
      <PageHeader title={'Atrybuty'}>
        <Breadcrumb />
      </PageHeader>

      <DataTable
        title="Grupa Atrybutów"
        filters={filters}
        setFilters={setFilters}
        columns={['Id', 'Name', 'Actions']}
        items={data}
        pagination={pagination}
        additionalFilters={[PaginationFilter]}
        actionButtons={<TableToolbarButtons />}
      />
    </>
  )
}

export default AttributeList;
