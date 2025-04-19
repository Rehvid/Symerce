import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import { useLocation, useNavigate } from 'react-router-dom';
import useListData from '@/admin/hooks/useListData';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import AppButton from '@/admin/components/common/AppButton';
import PlusIcon from '@/images/icons/plus.svg';

const ProductList = () => {
    const navigate = useNavigate();
    const location = useLocation();
    const currentFilters = new URLSearchParams(location.search);

    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { items, pagination, isLoading, fetchItems } = useListData('admin/products', filters);

    if (isLoading) {
        return <>...Loading</>;
    }

    const renderTableButtons = (
        <AppButton
            onClick={() => navigate('create')}
            variant="primary"
            additionalClasses="flex items-center justify-center gap-2 px-4 py-2.5"
        >
            <PlusIcon /> New Product
        </AppButton>
    );

    return (
        <>
            <PageHeader title={'Products'}>
                <Breadcrumb />
            </PageHeader>

            <DataTable
                title="Your Products"
                filters={filters}
                setFilters={setFilters}
                columns={['Id', 'Name', 'Slug', 'Actions']}
                items={items}
                pagination={pagination}
                additionalFilters={[PaginationFilter]}
                actionButtons={renderTableButtons}
                // useDraggable={true}
                // draggableCallback={draggableCallback}
            />
        </>
    );
};

export default ProductList;
