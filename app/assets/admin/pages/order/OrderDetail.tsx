import PageHeader from '@admin/layouts/components/PageHeader';
import React, { useEffect, useState } from 'react';
import OrderDetailBody from '@admin/modules/order/components/detail/OrderDetailBody';
import { useParams } from 'react-router-dom';
import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/shared/enums/httpEnums';
import { useApi } from '@admin/hooks/useApi';
import { ApiResponse } from '@admin/shared/types/apiResponse';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';

const OrderDetail = ({}) => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useApi();
  const [items, setItems] = useState<OrderDetailInterface | null>(null)
  
  useEffect(() => {
    handleApiRequest<ApiResponse<any>>(createApiConfig(`admin/orders/${params.id}/details`, HttpMethod.GET), {
      onSuccess: ({data}) => {
        setItems(data.data);
      }
    });
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
export default OrderDetail;
