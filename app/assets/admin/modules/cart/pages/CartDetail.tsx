import { useParams } from 'react-router-dom';
import React, { useEffect, useState } from 'react';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import PageHeader from '@admin/layouts/components/PageHeader';
import CartDetailBody from '@admin/modules/cart/components/CartDetailBody';
import { useAdminApi } from '@admin/common/context/AdminApiContext';


// TODO: Create shared components instead of duplicate
const CartDetail = () => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useAdminApi();
  const [items, setItems] = useState<OrderDetailInterface | null>(null)

    useEffect(() => {
        handleApiRequest(HttpMethod.GET, `admin/carts/${params.id}/details`, {
            onSuccess: ({ data }) => {
                setItems(data as OrderDetailInterface);
            },
        });

    }, [params.id]);

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
