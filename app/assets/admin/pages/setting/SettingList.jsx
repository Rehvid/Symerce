import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowDeleteAction from '@/admin/components/table/Partials/TableRow/TableRowDeleteAction';
import TableRowEditAction from '@/admin/components/table/Partials/TableRow/TableRowEditAction';

const SettingList = () => {
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
  } = useListData('admin/settings', filters);

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />
  }

  const actions = (item) => {
    const editPath = `${item.id}/edit`;

    if (item.isProtected) {
      return  (
        <div className="flex gap-2 items-start">
          <TableRowEditAction to={editPath}  />
        </div>
      )
    }

    return <TableActions
      editPath={editPath}
      onDelete={() => removeItem(`admin/settings/${item.id}`)}
    />
  }

  const data = items.map((item) => {
    return Object.values({
      id: item.id,
      name: item.name,
      type: item.type,
      value: item.value,
      actions: actions(item),
    });
  });

  return (
    <>
      <PageHeader title={'Ustawienia'}>
        <Breadcrumb />
      </PageHeader>

      <DataTable
        title="Globalne Ustawienia"
        filters={filters}
        setFilters={setFilters}
        columns={['Id', 'Name', 'Type', 'Value', 'Actions']}
        items={data}
        pagination={pagination}
        additionalFilters={[PaginationFilter]}
        actionButtons={<TableToolbarButtons/>}
      />
    </>
  )
}

export default SettingList;
