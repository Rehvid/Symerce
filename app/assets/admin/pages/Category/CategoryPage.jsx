import PageHeader from '../../components/Layout/PageHeader';
import Breadcrumb from '../../components/Navigation/Breadcrumb';
import RestApiClient from '../../../shared/api/RestApiClient';
import { useEffect, useState } from 'react';
import Table from '../../components/Table/Table';
import { prepareDataForTable } from '../../utilities/helper';
import TablePagination from '../../components/Table/TablePagination';
import { useLocation, useNavigate } from 'react-router-dom';
import AppButton from '../../components/Common/AppButton';
import PlusIcon from '../../../images/shared/plus.svg';
import restApiClient from '../../../shared/api/RestApiClient';
import TableActionHeader from '../../components/Table/Partials/TableActionHeader';
import PaginationFilter from '../../components/Table/Filters/PaginationFilter';
import TableRowDeleteAction from '../../components/Table/Partials/TableRow/TableRowDeleteAction';
import TableRowEditAction from '../../components/Table/Partials/TableRow/TableRowEditAction';
import { createApiConfig } from '@/shared/api/ApiConfig';
import {useApi} from "@/admin/hooks/useApi";

const CategoryPage = () => {
    const navigate = useNavigate();
    const location = useLocation();
    const {executeRequest} = useApi();

    const [didInit, setDidInit] = useState(false);
    const [categories, setCategories] = useState([]);
    const [pagination, setPagination] = useState({});
    const [filters, setFilters] = useState({
        limit: 5,
        page: 1,
    });

    const itemActions = category => (
        <div className="flex gap-2 items-start">
            <TableRowDeleteAction onClick={() => removeCategory(category.id)} />
            <TableRowEditAction to={`${category.id}/edit`} />
        </div>
    );

    useEffect(() => {
        (async () => {
            await getCategories();
            setDidInit(true);
        })();
    }, []);

    useEffect(() => {
        if (didInit) {
            (async () => {
                navigate(restApiClient().buildUrl(filters, location.pathname));
                await getCategories();
            })();
        }
    }, [filters]);

    const getCategories = async () => {
        const config = createApiConfig('category/list', 'GET', true).addQueryParams(filters);
        try {
            const { data, meta, errors } = await executeRequest(config);

            if (errors.length === 0) {
                setCategories(prepareDataForTable(data, {
                    actions: itemActions,
                }));
                setPagination(meta);
            }
        } catch (e) {
            console.error(e);
        }
    };

    const actionsTable = (
        <AppButton
            onClick={() => navigate('create')}
            variant="primary"
            additionalClasses="flex items-center justify-center gap-2 px-4 py-2.5"
        >
            <PlusIcon /> New Category
        </AppButton>
    );

    const removeCategory = async id => {
        const config = createApiConfig(`category/delete/${id}`, 'DELETE', true);
        const { errors } = await RestApiClient().executeRequest(config);
        if (errors.length === 0) {
            await getCategories();
        }
    };


    const data = prepareDataForTable(categories, {
        actions: itemActions,
    });

    if (!didInit) {
        return <div>Loading...</div>;
    }

    return (
        <>
            <PageHeader title={'Categories'}>
                <Breadcrumb />
            </PageHeader>

            <Table
                filters={filters}
                setFilters={setFilters}
                additionalFilters={[PaginationFilter]}
                columns={['Id', 'Name', 'Slug', 'Description', 'Actions']}
                actions={actionsTable}
                actionHeader={<TableActionHeader title="Your categories" total={pagination.totalItems} />}
                data={data}
            >
                <TablePagination filters={filters} setFilters={setFilters} pagination={pagination} />
            </Table>
        </>
    );
};

export default CategoryPage;
