import { useLocation, useNavigate } from 'react-router-dom';
import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import AppButton from '@/admin/components/common/AppButton';
import PlusIcon from '@/images/icons/plus.svg';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import UsersIcon from '@/images/icons/users.svg';
import TableRowDeleteAction from '@/admin/components/table/Partials/TableRow/TableRowDeleteAction';
import TableRowEditAction from '@/admin/components/table/Partials/TableRow/TableRowEditAction';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { useApi } from '@/admin/hooks/useApi';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';

const UserList = () => {
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
          <PlusIcon /> New User
      </AppButton>
    );

  const joinNameWithImage = (item) => (
    <div className="flex gap-4 items-center">
      {item.imagePath ? (
        <img src={item.imagePath} className="rounded-full w-12 h-12 object-cover" alt="Item image" />
      ) : (
        <div className="flex items-center w-12 h-12 bg-primary-light rounded-full ">
          <UsersIcon className="text-primary mx-auto" />
        </div>
      )}
      <span>{item.fullName}</span>
    </div>
  );

  const removeUser = async (id) => {
    const config = createApiConfig(`admin/users/${id}`, HTTP_METHODS.DELETE);
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
  const renderItemActions = (user) => (
    <div className="flex gap-2 items-start">
      <TableRowDeleteAction onClick={() => removeUser(user.id)} />
      <TableRowEditAction to={`${user.id}/edit`} />
    </div>
  );

  const { items, pagination, isLoading, fetchItems } = useListData('admin/users', filters);

  if (isLoading) {
    return <>...Loading</>;
  }


  const data = items.map((item) => {
      return Object.values({
        id: item.id,
        name: joinNameWithImage(item),
        slug: item.email,
        actions: renderItemActions(item),
      });
    });




    return (
      <>
          <PageHeader title={'Users'}>
              <Breadcrumb />
          </PageHeader>

          <DataTable
            title="Users"
            filters={filters}
            setFilters={setFilters}
            columns={['#', 'Użytkownik', 'Email', 'Akcje']}
            items={data}
            pagination={pagination}
            additionalFilters={[PaginationFilter]}
            actionButtons={renderTableButtons}
          />
      </>
    );
};

export default UserList;
