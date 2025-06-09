import { useParams } from 'react-router-dom';
import React, { useEffect, useState } from 'react';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import PageHeader from '@admin/layouts/components/PageHeader';
import ProductPriceHistoryBody from '@admin/modules/product/components/ProductPriceHistoryBody';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { ProductPriceHistory as ProductPriceHistoryInterface } from '@admin/modules/product/interfaces/ProductPriceHistory';

const ProductPriceHistory = () => {
  const params = useParams<{id: string}>();
  const { handleApiRequest } = useAdminApi();
  const [items, setItems] = useState<ProductPriceHistoryInterface[]| null>(null)

  useEffect(() => {
      if (!params.id) return;

      const fetchHistory = async () => {
          await handleApiRequest(HttpMethod.GET, `admin/products/${params.id}/product-history`, {
              onSuccess: ({ data }) => {
                  setItems(data as ProductPriceHistoryInterface[]);
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
      <PageHeader title="Historia cen produktu" />
      <ProductPriceHistoryBody items={items}/>
    </>
  )
}

export default ProductPriceHistory;
