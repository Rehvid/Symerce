import { createRoot } from 'react-dom/client';
import { Cart } from '@/shop/cart/components/Cart';

export const mountCart = () => {
  // const addToCart = document.querySelector('#product-add-to-cart');
  // if (addToCart) {
    createRoot(document.querySelector('#react-cart')).render(<Cart />)
  // }
}
