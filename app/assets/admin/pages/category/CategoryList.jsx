import { useState } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import AppButton from '../../components/common/AppButton';
import PlusIcon from '../../../images/icons/plus.svg';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '../../components/table/Filters/PaginationFilter';
import TableRowDeleteAction from '../../components/table/Partials/TableRow/TableRowDeleteAction';
import TableRowEditAction from '../../components/table/Partials/TableRow/TableRowEditAction';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { useApi } from '@/admin/hooks/useApi';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import DataTable from '@/admin/components/DataTable';
import useListData from '@/admin/hooks/useListData';

const CategoryList = () => {
    const navigate = useNavigate();
    const location = useLocation();
    const currentFilters = new URLSearchParams(location.search);

    const { handleApiRequest } = useApi();
    const { addNotification } = useCreateNotification();
    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const renderTableButtons = (
        <AppButton
            onClick={() => navigate('create')}
            variant="primary"
            additionalClasses="flex items-center justify-center gap-2 px-4 py-2.5"
        >
            <PlusIcon /> New Category
        </AppButton>
    );

    const renderItemActions = (category) => (
        <div className="flex gap-2 items-start">
            <TableRowDeleteAction onClick={() => removeCategory(category.id)} />
            <TableRowEditAction to={`${category.id}/edit`} />
        </div>
    );

    const removeCategory = async (id) => {
        const config = createApiConfig(`admin/categories/${id}`, HTTP_METHODS.DELETE);
        handleApiRequest(config, {
            onSuccess: ({ message }) => {
                addNotification(message, ALERT_TYPES.SUCCESS);

                const wasLastItemOnPage = items.length === 0;
                const isNotFirstPage = filters.page > 1;
                const shouldGoToPreviousPage = wasLastItemOnPage && isNotFirstPage;

                if (shouldGoToPreviousPage) {
                    setFilters((prevFilters) => ({
                        ...prevFilters,
                        page: prevFilters.page - 1,
                    }));
                } else {
                    fetchItems();
                }
            },
        });
    };

    const { items, pagination, isLoading, fetchItems } = useListData(
        'admin/categories',
        filters,
        setFilters,
        renderItemActions,
    );

    if (isLoading) {
        return <>...Loading</>;
    }

    return (
        <>
            <PageHeader title={'Categories'}>
                <Breadcrumb />
            </PageHeader>

            <DataTable
                title="Your categories"
                filters={filters}
                setFilters={setFilters}
                columns={['Id', 'Name', 'Slug', 'Actions']}
                pagination={pagination}
                additionalFilters={[PaginationFilter]}
                actionButtons={renderTableButtons}
                items={items}
            />
        </>
    );
};

export default CategoryList;
