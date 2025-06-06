import { useParams } from 'react-router-dom';
import { useApi } from '@admin/hooks/useApi';
import React, { useEffect, useState } from 'react';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import { ApiResponse } from '@admin/common/types/apiResponse';
import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import PageHeader from '@admin/layouts/components/PageHeader';
import CartDetailBody from '@admin/modules/cart/components/CartDetailBody';
import ProductPriceHistoryBody from '@admin/modules/product/components/ProductPriceHistoryBody';
import { useAdminApi } from '@admin/common/context/AdminApiContext';

const ProductPriceHistory = () => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useAdminApi();
  const [items, setItems] = useState<OrderDetailInterface | null>(null)

  useEffect(() => {
      if (!params.id) return;

      const fetchHistory = async () => {
          await handleApiRequest(HttpMethod.GET, `admin/products/${params.id}/product-history`, {
              onSuccess: ({ data }) => {
                  setItems(data as OrderDetailInterface);
              },
              onError: (errors) => {
                  console.error('API error:', errors);
              },
              onNetworkError: (error) => {
                  console.error('Network error:', error);
              },
          });
      };

      fetchHistory().catch(console.error);
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
