import { useEffect, useState } from 'react';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import RestApiClient from '@/shared/api/RestApiClient';
import SpinnerIcon from '@/images/icons/spinner.svg';
import { CartItem } from '@/shop/cart/components/CartItem';
import { updateCartCount } from '@/shop/cartManager';
import Heading from '@admin/common/components/Heading';

const Cart = () => {
  const [items, setItems] = useState();
  const [loading, setLoading] = useState(false);

  useEffect(() => {
      RestApiClient().sendApiRequest(createApiConfig('shop/cart', HTTP_METHODS.GET), {})
        .then(response => {
          setItems(response.data[0]);
          setLoading(true);
        })

  }, []);


  const onDelete = (id) => {
    const apiConfig = createApiConfig(`shop/cart/${id}`, HTTP_METHODS.DELETE);
    RestApiClient().sendApiRequest(apiConfig, {}).then(response => {
      const data = response.data[0];
      updateCartCount(- data.totalQuantity);
    });

    setItems((prev) => ({
      ...prev,
      cartItems: prev.cartItems.filter((cartItem) => cartItem.id !== id),
    }));
  }

  if (!loading) {
    return (
      <div className="flex flex-col items-center justify-center h-full">
        <SpinnerIcon className="animate-spin text-primary w-16 h-16" />
        <span className="sr-only">Ladowanie...</span>
      </div>
    )
  }

  if (!items || !items.cartItems?.length) {
    return <p className="text-center">Twój koszyk jest pusty.</p>;
  }

  return (
      <div className="flex flex-col gap-[1.5rem] lg:flex-row">
        <div className="w-full lg:flex-[2.75]">
          <div className="flex flex-col gap-[2rem]">
            {items.cartItems.map((item, key) => <CartItem key={key} item={item} onDelete={onDelete} />)}
          </div>
        </div>
        <div className="w-full lg:flex-[1.25]">
          <Heading level="h3" additionalClassNames="border-b-2 pb-2">Podusmowanie</Heading>
          <div className="flex flex-col gap-[1.25rem] mt-4">
            <div className="flex gap-4 items-center justify-between">
              <span>Razem</span>
              <span>Cena</span>
            </div>
            <div className="w-full mt-5">
              <a href="#" className=" text-center block px-4 py-2 bg-green-200 border border-green-200 rounded-lg transition-all duration-300 cursor-pointer hover:bg-green-300 hover:border-green-300">
                PRZEJDŹ DALEJ
              </a>
            </div>
          </div>

        </div>

      </div>
  )
}

export default Cart;
