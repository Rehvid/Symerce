import { useEffect } from 'react';

import { HTTP_METHODS } from '@/admin/constants/httpConstants';

export const Cart = () => {

  const handleClick = (e) => {
    const button = e.currentTarget;
    const productId = button.dataset.productId;

    const quantity = document.querySelector('#product-quantity');
    if (!quantity) {
      return;
    }

    const quantityValue = quantity.value;
    if (!quantityValue) {
      return;
    }

    const cartStorage = localStorage.getItem('cart');
    let cartToken = null;
    if (cartStorage) {
      const value = JSON.parse(cartStorage);
      cartToken = value.token;
    }

    handleRequest({
      productId: parseInt(productId),
      quantity: parseInt(quantityValue),
      cartToken,
      method: 'increase',
    });
  }

  const handleRequest = (data) => {
    fetch('http://localhost:4000/shop/api/cart/add-to-cart', {
      method: HTTP_METHODS.POST,
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
    }).then(response => response.json()).then(response => {
      const { data } = response;
      localStorage.setItem('cart', JSON.stringify(data.cart));
      //todo: ADD Toast
    });
  }

  const handleRemoveClick = (e) => {
    const button = e.currentTarget;
    console.log(button);
    const productId = button.dataset.productId;

    if (!productId) {
      return;
    }

    const data = {
      productId
    }

    fetch(`http://localhost:4000/shop/api/cart/${productId}`, {
      method: HTTP_METHODS.DELETE,
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
    }).then(response => response.json()).then(response => {
      const { data } = response;
      localStorage.setItem('cart', JSON.stringify(data.cart));
      //todo: ADD Toast
    });

  }

  useEffect(() => {
    const button = document.querySelector('#product-add-to-cart');
    if (!button) {
      return;
    }
    button.addEventListener('click', handleClick);


    return () => button.removeEventListener('click', handleClick);
  }, []);

  useEffect(() => {
    const removeItem = document.querySelector('.btn-remove-product');
    if (!removeItem) {
      return;
    }
    removeItem.addEventListener('click', handleRemoveClick);


    return () => removeItem.removeEventListener('click', handleRemoveClick)
  }, []);


  const btnQuantityChange = (e) => {
    const { currentTarget } = e;

    const method = currentTarget.dataset.method;
    const productId = parseInt(currentTarget.dataset.productId);
    const input = document.querySelector(`#product-cart-${productId}`);
    const quantity = method === 'increase' ? 1 : -1;

    const data = {
      productId,
      quantity,
      method: method,
      cartToken: '9e727553d3b38bbac647702fb0b76537_c0cf7bfc-afde-4c28-9cdd-b5ce64a5ce3c'
    }

    fetch('http://localhost:4000/shop/api/cart/increase-decrease', {
      method: HTTP_METHODS.PUT,
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
    }).then(response => response.json()).then(response => {
      const { data } = response;
      localStorage.setItem('cart', JSON.stringify(data.cart));
      //todo: ADD Toast
    });
  }

  useEffect(() => {
    document.querySelectorAll('.btn-quantity-change').forEach(element => {
      element.addEventListener('click', btnQuantityChange);
    })

    return () => document.querySelectorAll('.btn-quantity-change').forEach(element => {
      element.removeEventListener('click', btnQuantityChange);
    })
  }, []);


  return null;
}
