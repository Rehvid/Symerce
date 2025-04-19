import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import ProductIcon from '@/images/icons/assembly.svg';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';

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
    removeItem,
  } = useListData('admin/vendors', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }

  const data = items.map((item) => {
    const {id, name, imagePath} = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name: <TableRowImageWithText imagePath={imagePath} text={name} defaultIcon={<ProductIcon className="text-primary mx-auto" />} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/vendors/${item.id}`)}  />,
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
        columns={['ID', 'Nazwa', 'Akcje']}
        items={data}
        pagination={pagination}
        additionalFilters={[PaginationFilter]}
        actionButtons={<TableToolbarButtons/>}
      />
    </>
  )
}

export default VendorList;
