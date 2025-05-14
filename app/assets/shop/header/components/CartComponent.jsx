import ShoppingCartIcon from '@/images/icons/shopping-cart.svg';
import { useEffect, useState } from 'react';
import { clearCartCount, getCartCount, listenToCartUpdate } from '@/shop/cartManager';

const CartComponent = ({href}) => {
  const [cartCount, setCartCount] = useState(getCartCount());

  useEffect(() => {
    listenToCartUpdate(setCartCount);
  }, []);

  useEffect(() => {
    if (cartCount <= 0) {
      clearCartCount();
    }
  }, [cartCount]);

  return (
    <div className="relative">
      <a href={href}>
        <ShoppingCartIcon className="w-10 lg:w-[40px] h-auto text-primary"  />
        {cartCount > 0 && (
          <span className="absolute px-1 top-[-4px] right-[-2px] bg-green-200 text-black font-lg block min-w-[25px] min-h-[25px] rounded-full flex items-center justify-center text-xs">
            {cartCount}
          </span>
        )}
      </a>
    </div>
  )
}

export default CartComponent;
