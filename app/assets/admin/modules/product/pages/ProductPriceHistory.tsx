import { useParams } from 'react-router-dom';
import { useApi } from '@admin/hooks/useApi';
import React, { useEffect, useState } from 'react';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import { ApiResponse } from '@admin/shared/types/apiResponse';
import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/shared/enums/httpEnums';
import PageHeader from '@admin/layouts/components/PageHeader';
import CartDetailBody from '@admin/modules/cart/components/CartDetailBody';
import ProductPriceHistoryBody from '@admin/modules/product/components/ProductPriceHistoryBody';

const ProductPriceHistory = () => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useApi();
  const [items, setItems] = useState<OrderDetailInterface | null>(null)

  useEffect(() => {
    handleApiRequest<ApiResponse<any>>(createApiConfig(`admin/products/${params.id}/product-history`, HttpMethod.GET), {
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
      <PageHeader title="Historia cen dla produktu" />
      <ProductPriceHistoryBody items={items}/>
    </>
  )
}

export default ProductPriceHistory;
