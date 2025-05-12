import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import ListHeader from '@/admin/components/ListHeader';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import TableRowActiveBadge from '@/admin/components/table/Partials/TableRow/TableRowActiveBadge';
import TableActions from '@/admin/components/table/Partials/TableActions';
import TableRowMoney from '@/admin/components/table/Partials/TableRow/TableRowMoney';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import ProductIcon from '@/images/icons/assembly.svg';
import useDraggable from '@/admin/hooks/useDraggable';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';
import ActiveFilter from '@/admin/components/table/Filters/ActiveFilter';
import RangeFilter from '@/admin/components/table/Filters/RangeFilter';
import { filterEmptyValues } from '@/admin/utils/helper';
import ExactValueFilter from '@/admin/components/table/Filters/ExactValueFilter';
import TableRowShowAction from '@/admin/components/table/Partials/TableRow/TableRowShowAction';

const ProductList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();

    const [filters, setFilters] = useState(
        filterEmptyValues({
            ...defaultFilters,
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
            regularPriceFrom: getCurrentParam('regularPriceFrom', (value) => Number(value)),
            regularPriceTo: getCurrentParam('regularPriceTo', (value) => Number(value)),
            discountPriceFrom: getCurrentParam('discountPriceFrom', (value) => Number(value)),
            discountPriceTo: getCurrentParam('discountPriceTo', (value) => Number(value)),
            quantity: getCurrentParam('quantity', (value) => Number(value)),
        }),
    );

    const { draggableCallback } = useDraggable('admin/products/order');
    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/products',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const renderActions = (item) => (
      <TableActions id={item.id} onDelete={() => removeItem(`admin/products/${item.id}`)} >
          <TableRowShowAction href={item.showUrl}/>
      </TableActions>
    )

    const data = items.map((item) => {
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

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'discountPrice.amount', label: 'Cena Promocyjna', sortable: true },
        { orderBy: 'regularPrice.amount', label: 'Cena Regularna', sortable: true },
        { orderBy: 'quantity', label: 'Ilość', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    const additionalFilters = [
        <ActiveFilter setFilters={setFilters} filters={filters} />,
        <RangeFilter filters={filters} setFilters={setFilters} label="Cena Regularna" nameFilter="regularPrice" />,
        <RangeFilter filters={filters} setFilters={setFilters} label="Cena promocyjna" nameFilter="discountPrice" />,
        <ExactValueFilter filters={filters} setFilters={setFilters} label="Ilość" nameFilter="quantity" />,
    ];

    const additionalToolbarContent = (
        <PageHeader title={<ListHeader title="Produkty" totalItems={pagination.totalItems} />}>
            <TableToolbarButtons />
        </PageHeader>
    );

    return (
        <DataTable
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
};

export default ProductList;
