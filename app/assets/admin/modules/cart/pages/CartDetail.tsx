import { useParams } from 'react-router-dom';
import React, { useEffect, useState } from 'react';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import PageHeader from '@admin/layouts/components/PageHeader';
import CartDetailBody from '@admin/modules/cart/components/CartDetailBody';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { CartDetailData } from '@admin/modules/cart/interfaces/CartDetailData';

const CartDetail = () => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useAdminApi();
  const [detailData, setDetailData] = useState<CartDetailData | null>(null)

    useEffect(() => {
        handleApiRequest(HttpMethod.GET, `admin/carts/${params.id}/details`, {
            onSuccess: ({ data }) => {
                setDetailData(data as CartDetailData);
            },
        }).catch(error => console.error(error));

    }, [params.id]);

  if (!detailData) {
    return;
  }

  return (
    <>
      <PageHeader title="Detale koszyka" />
      <CartDetailBody detailData={detailData}/>
    </>
  )
}

export default CartDetail;
