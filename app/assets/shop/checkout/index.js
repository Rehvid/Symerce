import { createRoot } from 'react-dom/client';
import CheckoutApp from '@/shop/checkout/CheckoutApp';


const mountCart = () => {
  const checkoutRoot = document.querySelector('#react-checkout-root');
  if (checkoutRoot) {
    createRoot(checkoutRoot).render(<CheckoutApp step={checkoutRoot.dataset.step} />)
  }
}

document.addEventListener('DOMContentLoaded', () => {
  mountCart();
});
