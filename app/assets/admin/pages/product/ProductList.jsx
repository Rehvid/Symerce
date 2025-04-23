import { useState } from 'react';
import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import { useLocation, useNavigate } from 'react-router-dom';
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

const ProductList = () => {
    const location = useLocation();
    const currentFilters = new URLSearchParams(location.search);

    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { items, pagination, isLoading, removeItem } = useListData('admin/products', filters);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item => {
      const {discountedPrice, regularPrice, id, name, isActive, quantity, image} = item;
      return Object.values({
        id: <TableRowId id={id} />,
        name:  (
          <TableRowImageWithText
            imagePath={image}
            text={name}
            defaultIcon={<ProductIcon className="text-primary mx-auto" />}
          />
        ),
        discountPrice:  <TableRowMoney amount={discountedPrice?.amount} symbol={discountedPrice?.symbol} />,
        regularPrice:  <TableRowMoney amount={regularPrice?.amount} symbol={regularPrice?.symbol} />,
        quantity,
        active: <TableRowActiveBadge isActive={isActive} />,
        actions: <TableActions id={id} onDelete={() => removeItem(`admin/products/${id}`)} />,
      })
    }));


    return (
        <>
            <PageHeader title={<ListHeader title="Produkty" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Cena Regularna', 'Cena Promocyjna', 'Ilość', 'Aktywny', 'Actions']}
                items={data}
                pagination={pagination}
            />
        </>
    );
};

export default ProductList;
