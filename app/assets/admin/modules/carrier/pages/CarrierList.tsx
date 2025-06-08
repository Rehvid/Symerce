import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { BrandListFiltersInterface } from '@admin/modules/brand/interfaces/BrandListFiltersInterface';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { BrandListItemInterface } from '@admin/modules/brand/interfaces/BrandListItemInterface';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import ProductIcon from '@/images/icons/assembly.svg';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { TagListItemInterface } from '@admin/modules/tag/interfaces/TagListItemInterface';
import { TagListFiltersInterface } from '@admin/modules/tag/interfaces/TagListFiltersInterface';
import { CarrierListFiltersInterface } from '@admin/modules/carrier/interfaces/CarrierListFiltersInterface';
import { CarrierListItemInterface } from '@admin/modules/carrier/interfaces/CarrierListItemInterface';
import CarrierIcon from '@/images/icons/carrier.svg';
import TableRowMoney from '@admin/common/components/tableList/tableRow/TableRowMoney';

const CarrierList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<CarrierListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
      feeFrom: getCurrentParam('feeFrom', (value) => Number(value)),
      feeTo: getCurrentParam('feeTo', (value) => Number(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<CarrierListItemInterface>({
    endpoint: 'admin/carriers',
    filters,
    setFilters,
    defaultSort,
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item: CarrierListItemInterface) => {
    const { id, imagePath, isActive, name, fee } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name: (
        <TableRowImageWithText
          imagePath={imagePath}
          text={name}
          defaultIcon={<CarrierIcon className="text-primary mx-auto w-[24px] h-[24px]" />}
        />
      ),
      active: <TableRowActive isActive={isActive} />,
      fee: <TableRowMoney amount={fee?.amount} symbol={fee?.symbol} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/carriers/${id}`)} />,
    });
  });

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'fee', label: 'Opłata', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Przewoźnicy" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<CarrierListItemInterface, CarrierListFiltersInterface>
      filters={filters}
      setFilters={setFilters}
      defaultFilters={defaultFilters}
      sort={sort}
      setSort={setSort}
      columns={columns}
      items={data}
      pagination={pagination}
      additionalToolbarContent={additionalToolbarContent}
    />
  );
}

export default CarrierList;
