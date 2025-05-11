import { createRoot } from 'react-dom/client';
import CategoryShowSwiper from '@/shop/category/components/CategoryShowSwiper';


document.addEventListener('DOMContentLoaded', () => {
  mountSwiper();
});

const mountSwiper = () => {
  const reactSwiper = document.querySelector('.react-category-swiper');
  if (!reactSwiper) {
    return;
  }

  const categories = reactSwiper.getAttribute('data-categories');
  let items = [];

  try {
    items = JSON.parse(categories);
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

  createRoot(reactSwiper).render(<CategoryShowSwiper items={items}/>)
};
