import { createRoot } from 'react-dom/client';
import Dropdown from '@/shop/common/components/Dropdown';
import DOMPurify from 'quill/formats/link';

document.addEventListener('DOMContentLoaded', () => {
  mountDropdowns();
});

const mountDropdowns = () => {
    document.querySelectorAll('.react-dropdown').forEach((parentDropdown) => {
      const placeholder = parentDropdown.querySelector('.react-dropdown-placeholder');
      const dataContent = parentDropdown.getAttribute('data-content');
      const dataUseChevronIcon = parentDropdown.getAttribute('data-use-chevron');

      if (placeholder) {
        createRoot(placeholder).render(
          <Dropdown parentElement={parentDropdown} useChevronIcon={Boolean(dataUseChevronIcon)}>
            <div dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(dataContent) }} />
          </Dropdown>
        );
      }
    });
};
