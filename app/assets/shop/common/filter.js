import { renderOverlay } from '@/shop/overlayManager';
import FilterModalToggle from '@/shop/common/components/FilterModalToggle';

document.addEventListener('DOMContentLoaded', () => {
  mountFilter();
});

const mountFilter = () => {
  const reactFilterToggle = document.querySelector('.react-filter-toggle');

  if (!reactFilterToggle) {
    return;
  }

  const dataMenu = reactFilterToggle.getAttribute('data-filters');
  let items = [];

  try {
    items = JSON.parse(dataMenu);
  } catch (e) {
    console.error(e.message);
    console.error('Cannot parse submenu data!');
  }

  reactFilterToggle.addEventListener('click', (e) => {
    e.preventDefault();
    renderOverlay(<FilterModalToggle items={items} />);
  });
}
