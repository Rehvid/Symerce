import PageHeader from '@admin/layouts/components/PageHeader';
import React, { useEffect, useState } from 'react';
import OrderDetailBody from '@admin/modules/order/components/detail/OrderDetailBody';
import { useParams } from 'react-router-dom';
import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/common/enums/httpEnums';

import { ApiResponse } from '@admin/common/types/apiResponse';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import { useAdminApi } from '@admin/common/context/AdminApiContext';

const OrderDetailPage = ({}) => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useAdminApi();
  const [items, setItems] = useState<OrderDetailInterface | null>(null)
  
  useEffect(() => {
      const fetchDetails = async () => {
          await handleApiRequest(HttpMethod.GET, `admin/orders/${params.id}/details`, {
              onSuccess: ({ data }) => {
                  setItems(data as OrderDetailInterface);
              },
          });
      };

      fetchDetails().catch(console.error);
  }, []);

  if (!items) {
    return;
  }

  return (
    <>
      <PageHeader title="Detale transakcji" />
      <OrderDetailBody items={items}/>
    </>
  )
}
export default OrderDetailPage;
