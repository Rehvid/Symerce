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

function CategoryPage() {
    const navigate = useNavigate();
    const location = useLocation();

    const [categories, setCategories] = useState([]);
    const [total, setTotal] = useState(0);
    const [rendered, setRendered] = useState(0);
    const [didInit, setDidInit] = useState(false);
    const [filters, setFilters] = useState({
        perPage: 2,
        page: 1,
    });

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
        const config = RestApiClient().createConfig('category/list', 'GET', {}, filters);
        try {
            const { data, total, rendered } = await RestApiClient().sendRequest(config);

            setCategories(data);
            setTotal(total);
            setRendered(rendered);
        } catch (e) {
            console.error(e);
        }
    };

    if (categories.length === 0) {
        return <>Loading...</>;
    }

    const actionsTable = (
        <AppButton onClick={() => navigate('create')} variant="primary" additionalClasses="flex items-center justify-center gap-2 px-4 py-2.5">
            <PlusIcon /> New Category
        </AppButton>
    );

    const itemActions = (
        <div className="flex gap-2 items-start">
            <TableRowDeleteAction to={'#'} />
            <TableRowEditAction to={'#'} />
        </div>
    );

    const data = prepareDataForTable(categories, {
        actions: itemActions,
    });

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
                actionHeader={<TableActionHeader title="Your categories" total={total} />}
                data={data}
            >
                <TablePagination
                    filters={filters}
                    setFilters={setFilters}
                    total={total}
                    rendered={rendered}
                    perPage={filters.perPage}
                />
            </Table>
        </>
    );
}

export default CategoryPage;
