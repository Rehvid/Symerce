import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import TableActions from '@admin/common/components/table/partials/TableActions';
import TableRowShowAction from '@admin/common/components/table/partials/tableRow/TableRowShowAction';
import TableRowId from '@admin/common/components/table/partials/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/table/partials/tableRow/TableRowImageWithText';
import ProductIcon from '@/images/icons/assembly.svg';
import TableRowMoney from '@admin/common/components/table/partials/tableRow/TableRowMoney';
import TableRowActiveBadge from '@admin/common/components/table/partials/tableRow/TableRowActiveBadge';
import ActiveFilter from '@admin/common/components/table/partials/filters/ActiveFilter';
import RangeFilter from '@admin/common/components/table/partials/filters/RangeFilter';
import ExactValueFilter from '@admin/common/components/table/partials/filters/ExactValueFilter';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { TableColumn } from '@admin/common/types/tableColumn';
import useDraggable from '@admin/common/hooks/list/useDraggable';
import { useListData } from '@admin/common/hooks/list/useListData';
import { ProductListFiltersInterface } from '@admin/modules/product/interfaces/ProductListFiltersInterface';
import { ProductListItemInterface } from '@admin/modules/product/interfaces/ProductListItemInterface';
import Link from '@admin/common/components/Link';
import HistoryIcon from '@/images/icons/history.svg'
import { useAppData } from '@admin/common/context/AppDataContext';


const ProductListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const { data: globalData } = useAppData();
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
        <Link to={`${item.id}/price-history`}>
          <HistoryIcon className="h-[24px] w-[24px] text-gray-500" />
        </Link>
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
