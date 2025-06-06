import Heading from '@admin/common/components/Heading';
import PlaceholderImage from '@/images/placeholder-image.png';
import TrashIcon from '@/images/icons/trash.svg';
import InputQuantity from '@/shop/components/InputQuantity';
import { useEffect, useState } from 'react';
import RestApiClient from '@/shared/api/RestApiClient';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { updateCartCount } from '@/shop/cartManager';

export const CartItem = ({item, onDelete}) => {
  const [isRefreshing, setIsRefreshing] = useState(false);
  const [quantity, setQuantity] = useState(item.quantity);

  useEffect(() => {
    setQuantity(item.quantity);
  }, [item]);

  const onChange = (value) => {
    setQuantity(value);
    console.log(value);
    const apiConfig = createApiConfig(`shop/cart/change-quantity/`, HTTP_METHODS.PUT);
    apiConfig.setBody({
      productId: parseInt(item.productId),
      newQuantity: value
    });

    setIsRefreshing(true);
    RestApiClient().sendApiRequest(apiConfig, {})
      .then((response) => {
        const data = response.data[0];
        updateCartCount(data.totalQuantity);
        setIsRefreshing(false);
      })
  }

  return (
    <div id={`product-${item.productId}`} className={`flex gap-4 border-b border-gray-200 pb-[1.5rem] transition-all duration-300 ${isRefreshing ? 'filter blur-sm pointer-events-none' : ''} `}>
      <div className="w-full max-w-[120px]">
        <div className="w-full h-full pb-[100%] relative">
          <img className="absolute inset-0 w-full h-full object-cover rounded-xl"
               src={item.productImage === null ? PlaceholderImage : item.productImage}
               alt={`Product Image - ${item.productId}`} />
        </div>
      </div>
      <div className="flex flex-col justify-between">
        <div>
          <div className="flex gap-4 justify-between items-center">
            <a href={item.productUrl}>
              <Heading level="h3" additionalClassNames="text-primary-content hover:text-primary transtion-all duration-300">{item.productName}</Heading>
            </a>
            <span>{item.price}</span>
          </div>
        </div>
        <div className="flex gap-4 items-center">
          <InputQuantity
            quantity={quantity}
            id={`product-${item.productId}`}
            onChange={onChange}
          />
          <span className="cursor-pointer  duration-300 transition-all hover:text-primary" onClick={() => onDelete(item.id)}>
              <TrashIcon className="w-[30px] h-[30px]"  />
            </span>
        </div>
      </div>
    </div>
  )
}


