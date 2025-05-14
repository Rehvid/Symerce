const CART_COUNT_KEY = 'cartCount';

export const getCartCount = () => {
  return parseInt(localStorage.getItem(CART_COUNT_KEY), 10) || 0;
};

export const clearCartCount = () => {
  localStorage.removeItem(CART_COUNT_KEY);
}

export const setCartCount = (count) => {
  localStorage.setItem(CART_COUNT_KEY, count);
  dispatchCartUpdate(count);
};

export const updateCartCount = (diff) => {
  const newCount = getCartCount() + diff;
  setCartCount(newCount);
};

export const dispatchCartUpdate = (count) => {
  window.dispatchEvent(new CustomEvent('cartCountUpdated', { detail: count }));
};

export const listenToCartUpdate = (callback) => {
  window.addEventListener('cartCountUpdated', (e) => {
    callback(e.detail);
  });
};
