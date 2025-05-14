import InputQuantity from '@/shop/components/InputQuantity';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import RestApiClient from '@/shared/api/RestApiClient';
import { updateCartCount } from '@/shop/cartManager';
import { useState } from 'react';

const ProductAddToCart = ({productId}) => {
  const DEFAULT_QUANTITY = 1;

  const [quantity, setQuantity] = useState(DEFAULT_QUANTITY);

  const handleQuantity = (value) => {
    setQuantity(value);
  }

  const handleAddProduct = () => {
    const apiConfig = createApiConfig(`shop/cart`, HTTP_METHODS.POST);
    apiConfig.setBody({
      productId,
      quantity
    });

    RestApiClient().sendApiRequest(apiConfig, {})
      .then((response) => {
        const data = response.data['cart'];
        
        updateCartCount(data.totalQuantity);
        setQuantity(DEFAULT_QUANTITY);
      })
  }

  return (
    <div className="flex gap-4 flex-col sm:flex-row  sm:justify-between sm:items-center">
      <InputQuantity
        id={`product-${productId}`}
        instantRefresh={true}
        quantity={quantity}
        onChange={handleQuantity}
      />
      <button onClick={() => handleAddProduct()} className="sm:w-75 px-4 py-2 bg-green-200 border border-green-200 rounded-lg transition-all duration-300 cursor-pointer hover:bg-green-300 hover:border-green-300">
        Dodaj do koszyka
      </button>
    </div>

  )
}

export default ProductAddToCart;
