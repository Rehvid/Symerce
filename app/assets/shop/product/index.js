import { createRoot } from 'react-dom/client';
import ProductThumbnailSwiper from '@/shop/product/components/ProductThumbnailSwiper';
import ProductTab from '@/shop/product/components/ProductTab';
import ProductAddToCart from '@/shop/product/components/ProductAddToCart';

document.addEventListener('DOMContentLoaded', () => {
  mountSwiper();
  mountProductTabs();
  mountProductAddItem();
});

const mountSwiper = () => {
  const reactSwiper = document.querySelector('.react-product-thumbnail-swiper');
  if (!reactSwiper) {
    return;
  }

  const images = reactSwiper.getAttribute('data-images');
  let items = [];

  try {
    items = JSON.parse(images);
  } catch (e) {
    console.error(e.message);
    console.error('Cannot parse submenu data!');
  }

  if (
    (Array.isArray(items) && items.length <= 0) ||
    (typeof items === 'object' && Object.values(items).length <= 0)
  ) {
    return;
  }

  createRoot(reactSwiper).render(<ProductThumbnailSwiper images={items} />)
};

const mountProductTabs = () => {
  const productTab = document.querySelector('.react-product-tab');
  const contentContainer = document.querySelector('.react-product-tab-content');


  if (!productTab || !contentContainer) {
    return;
  }
  const types = productTab.getAttribute('data-types');
  const defaultActiveTab = productTab.getAttribute('data-active-tab');
  let items = [];

  try {
    items = JSON.parse(types);
  } catch (e) {
    console.error(e.message);
    console.error('Cannot parse submenu data!');
  }

  if (
    (Array.isArray(items) && items.length <= 0) ||
    (typeof items === 'object' && Object.values(items).length <= 0)
  ) {
    return;
  }

  const handleTabClick = (e) => {
    const target = e.target;
    if (target.classList.contains('react-product-tab-element')) {
      const type = target.getAttribute('data-type');
      const content = target.getAttribute('data-content');
      if (type !== defaultActiveTab) {
        const activeTab = {type, content}
        createRoot(contentContainer).render(
          <ProductTab types={items} activeTab={activeTab} defaultActiveTabType={defaultActiveTab} activeTabTarget={target} />
        );
        document.removeEventListener('click', handleTabClick);
      }
    }
  };

  document.addEventListener('click', handleTabClick);
}

const mountProductAddItem = () => {
  const element = document.querySelector('#react-product-add-to-cart');
  if (element) {
    const productId = element.dataset.productId;
    createRoot(element).render(<ProductAddToCart productId={productId}  />)
  }
}
