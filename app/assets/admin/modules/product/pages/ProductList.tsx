import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues, stringToBoolean } from '@admin/common/utils/helper';
import TableActions from '@admin/common/components/tableList/TableActions';
import TableRowShowAction from '@admin/common/components/tableList/tableRow/TableRowExternalLinkAction';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import ProductIcon from '@/images/icons/assembly.svg';
import TableRowMoney from '@admin/common/components/tableList/tableRow/TableRowMoney';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import RangeFilter from '@admin/common/components/tableList/filters/RangeFilter';
import ExactValueFilter from '@admin/common/components/tableList/filters/ExactValueFilter';
import useDraggable from '@admin/common/hooks/list/useDraggable';
import { useListData } from '@admin/common/hooks/list/useListData';
import { ProductTableFilters } from '@admin/modules/product/interfaces/ProductTableFilters';
import { ProductListItem } from '@admin/modules/product/interfaces/ProductListItem';
import Link from '@admin/common/components/Link';
import HistoryIcon from '@/images/icons/history.svg';
import { useSetting } from '@admin/common/context/AppDataContext';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { TableColumn } from '@admin/common/types/tableColumn';
import TablePagination from '@admin/common/components/tableList/TablePagination';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';

const ProductList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const enablePriceHistory = useSetting('enable_price_history');

    const [filters, setFilters] = useState<ProductTableFilters>(
        filterEmptyValues({
            ...defaultFilters,
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
            regularPriceFrom: getCurrentParam('regularPriceFrom', (value) => Number(value)),
            regularPriceTo: getCurrentParam('regularPriceTo', (value) => Number(value)),
            quantity: getCurrentParam('quantity', (value) => Number(value)),
            search: getCurrentParam('search', (value) => String(value)),
        }) as ProductTableFilters,
    );

    const { draggableCallback } = useDraggable('admin/position/product');

    const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<
        ProductListItem,
        ProductTableFilters
    >({
        endpoint: 'admin/products',
        filters,
        setFilters,
        defaultSort,
    });

    const renderActions = (item: ProductListItem) => (
        <TableActions id={item.id} onDelete={() => removeItem(`admin/products/${item.id}`)}>
            <TableRowShowAction href={item.showUrl} />
            {enablePriceHistory && stringToBoolean(enablePriceHistory.value.value) && (
                <Link
                    to={`${item.id}/price-history`}
                    additionalClasses="inline-flex items-center justify-center w-8 h-8 rounded transition-colors cursor-pointer bg-purple-100 hover:bg-purple-300 text-purple-600 "
                    title="Historia cen"
                    aria-label="Historia cen"
                >
                    <HistoryIcon className="h-5 w-5" />
                </Link>
            )}
        </TableActions>
    );

    const rowData = items.map((item: ProductListItem) => [
        <TableRowId id={item.id} />,
        <TableRowImageWithText
            imagePath={item.image}
            text={item.name}
            defaultIcon={<ProductIcon className="text-primary mx-auto" />}
        />,
        <TableRowMoney amount={item.discountedPrice?.amount} symbol={item.discountedPrice?.symbol} />,
        <TableRowMoney amount={item.regularPrice?.amount} symbol={item.regularPrice?.symbol} />,
        item.quantity,
        <TableRowActive isActive={item.isActive} />,
        renderActions(item),
    ]);

    const columns: TableColumn[] = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'discountPrice.amount', label: 'Cena Promocyjna', sortable: true },
        { orderBy: 'regularPrice.amount', label: 'Cena Regularna', sortable: true },
        { orderBy: 'quantity', label: 'Ilość', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista produktów" totalItems={pagination?.totalItems} />
                <TableToolbarFilters
                    sort={sort}
                    setSort={setSort}
                    filters={filters}
                    setFilters={setFilters}
                    defaultFilters={defaultFilters}
                >
                    <ActiveFilter setFilters={setFilters} filters={filters} />
                    <RangeFilter
                        filters={filters}
                        setFilters={setFilters}
                        label="Cena Regularna"
                        nameFilter="regularPrice"
                    />
                    <RangeFilter
                        filters={filters}
                        setFilters={setFilters}
                        label="Cena promocyjna"
                        nameFilter="discountPrice"
                    />
                    <ExactValueFilter filters={filters} setFilters={setFilters} label="Ilość" nameFilter="quantity" />
                </TableToolbarFilters>
            </TableToolbar>
            <TableWrapper isLoading={isLoading}>
                <TableHead sort={sort} setSort={setSort} columns={columns} />
                <TableBody
                    data={rowData}
                    filters={filters}
                    pagination={pagination as Pagination}
                    useDraggable={true}
                    draggableCallback={draggableCallback}
                />
            </TableWrapper>
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination as Pagination} />
        </TableWithLoadingSkeleton>
    );
};

export default ProductList;
