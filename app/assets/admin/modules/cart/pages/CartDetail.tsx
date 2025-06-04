import { useParams } from 'react-router-dom';
import { useApi } from '@admin/hooks/useApi';
import React, { useEffect, useState } from 'react';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import { ApiResponse } from '@admin/shared/types/apiResponse';
import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/shared/enums/httpEnums';
import PageHeader from '@admin/layouts/components/PageHeader';
import OrderDetailBody from '@admin/modules/order/components/detail/OrderDetailBody';
import CartDetailBody from '@admin/modules/cart/components/CartDetailBody';


// TODO: Create shared components instead of duplicate
const CartDetail = () => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useApi();
  const [items, setItems] = useState<OrderDetailInterface | null>(null)

  useEffect(() => {
    handleApiRequest<ApiResponse<any>>(createApiConfig(`admin/carts/${params.id}/details`, HttpMethod.GET), {
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
      <PageHeader title="Detale koszyka" />
      <CartDetailBody items={items}/>
    </>
  )
}

export default CartDetail;
