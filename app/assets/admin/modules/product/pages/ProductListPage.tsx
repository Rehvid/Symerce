import useListDefaultQueryParams from '@admin/shared/hooks/list/useListDefaultQueryParams';
import { useState } from 'react';
import { filterEmptyValues } from '@admin/utils/helper';
import TableSkeleton from '@admin/components/skeleton/TableSkeleton';
import TableActions from '@admin/components/table/Partials/TableActions';
import TableRowShowAction from '@admin/components/table/Partials/TableRow/TableRowShowAction';
import TableRowId from '@admin/components/table/Partials/TableRow/TableRowId';
import TableRowImageWithText from '@admin/components/table/Partials/TableRow/TableRowImageWithText';
import ProductIcon from '@/images/icons/assembly.svg';
import TableRowMoney from '@admin/components/table/Partials/TableRow/TableRowMoney';
import TableRowActiveBadge from '@admin/components/table/Partials/TableRow/TableRowActiveBadge';
import ActiveFilter from '@admin/components/table/Filters/ActiveFilter';
import RangeFilter from '@admin/components/table/Filters/RangeFilter';
import ExactValueFilter from '@admin/components/table/Filters/ExactValueFilter';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/components/ListHeader';
import TableToolbarButtons from '@admin/components/table/Partials/TableToolbarButtons';
import DataTable from '@admin/shared/components/table/DataTable';
import { TableColumn } from '@admin/shared/types/tableColumn';
import useDraggable from '@admin/shared/hooks/list/useDraggable';
import { useListData } from '@admin/shared/hooks/list/useListData';
import { ProductListFiltersInterface } from '@admin/modules/product/interfaces/ProductListFiltersInterface';
import { ProductListItemInterface } from '@admin/modules/product/interfaces/ProductListItemInterface';
import { useData } from '@admin/hooks/useData';
import AppLink from '@admin/components/common/AppLink';
import HistoryIcon from '@/images/icons/history.svg'


const ProductListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const { data: globalData } = useData();
  const enableProductHistory = globalData?.settings.find(setting => setting.settingKey === 'enable_price_history')?.value?.value;


  const [filters, setFilters] = useState<ProductListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
      regularPriceFrom: getCurrentParam('regularPriceFrom', (value) => Number(value)),
      regularPriceTo: getCurrentParam('regularPriceTo', (value) => Number(value)),
      quantity: getCurrentParam('quantity', (value) => Number(value)),
    }),
  );

  const { draggableCallback } = useDraggable('admin/reorder/product');


  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<ProductListItemInterface>({
    endpoint: 'admin/products',
    filters,
    setFilters,
    defaultSort,
  });


  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const renderActions = (item: ProductListItemInterface) => (
    <TableActions id={item.id} onDelete={() => removeItem(`admin/products/${item.id}`)} >
      <TableRowShowAction href={item.showUrl}/>
      {enableProductHistory === '1' && (
        <AppLink to={`${item.id}/price-history`}>
          <HistoryIcon className="h-[24px] w-[24px] text-gray-500" />
        </AppLink>
      )}
    </TableActions>
  )

  const data = items.map((item: ProductListItemInterface) => {
    const { discountedPrice, regularPrice, id, name, isActive, quantity, image } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name: (
        <TableRowImageWithText
          imagePath={image}
          text={name}
          defaultIcon={<ProductIcon className="text-primary mx-auto" />}
        />
      ),
      discountPrice: <TableRowMoney amount={discountedPrice?.amount} symbol={discountedPrice?.symbol} />,
      regularPrice: <TableRowMoney amount={regularPrice?.amount} symbol={regularPrice?.symbol} />,
      quantity,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions: renderActions(item),
    });
  });

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'discountPrice.amount', label: 'Cena Promocyjna', sortable: true },
    { orderBy: 'regularPrice.amount', label: 'Cena Regularna', sortable: true },
    { orderBy: 'quantity', label: 'Ilość', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalFilters: JSX.Element[] = [
    <ActiveFilter setFilters={setFilters} filters={filters} />,
    <RangeFilter filters={filters} setFilters={setFilters} label="Cena Regularna" nameFilter="regularPrice" />,
    <RangeFilter filters={filters} setFilters={setFilters} label="Cena promocyjna" nameFilter="discountPrice" />,
    <ExactValueFilter filters={filters} setFilters={setFilters} label="Ilość" nameFilter="quantity" />,
  ];

  const additionalToolbarContent: JSX.Element = (
    <PageHeader title={<ListHeader title="Produkty" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<ProductListItemInterface, ProductListFiltersInterface>
      filters={filters}
      setFilters={setFilters}
      defaultFilters={defaultFilters}
      sort={sort}
      setSort={setSort}
      columns={columns}
      items={data}
      pagination={pagination}
      useDraggable
      draggableCallback={draggableCallback}
      additionalFilters={additionalFilters}
      additionalToolbarContent={additionalToolbarContent}
    />
  );
}

export default ProductListPage;
