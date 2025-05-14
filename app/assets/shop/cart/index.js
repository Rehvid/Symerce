import { createRoot } from 'react-dom/client';
import Cart from '@/shop/cart/components/Cart';

const mountCart = () => {
    const reactCart = document.querySelector('#react-cart');
    if (reactCart) {
        createRoot(reactCart).render(<Cart />)
    }
}

document.addEventListener('DOMContentLoaded', () => {
    mountCart();
});



