import PageHeader from '@admin/layouts/components/PageHeader';
import React, { useEffect, useState } from 'react';
import OrderDetailBody from '@admin/modules/order/components/detail/OrderDetailBody';
import { useParams } from 'react-router-dom';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { OrderDetail as OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetail';
import { useAdminApi } from '@admin/common/context/AdminApiContext';

const OrderDetail = ({}) => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useAdminApi();
  const [detailData, setDetailData] = useState<OrderDetailInterface | null>(null)
  
  useEffect(() => {
      const fetchDetails = async () => {
          await handleApiRequest(HttpMethod.GET, `admin/orders/${params.id}/details`, {
              onSuccess: ({ data }) => {
                  setDetailData(data as OrderDetailInterface);
              },
          });
      };

      fetchDetails().catch(console.error);
  }, []);

  if (!detailData) {
    return;
  }

  return (
    <>
      <PageHeader title="Detale transakcji" />
      <OrderDetailBody detailData={detailData}/>
    </>
  )
}
export default OrderDetail;
