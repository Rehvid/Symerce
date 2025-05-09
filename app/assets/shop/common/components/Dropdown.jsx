import { useClickToggleBySelector } from '@/shop/hooks/useClickToggleBySelector';

const Dropdown = ({parentElement, useChevronIcon = false, children}) => {

  const handler = (e) => {
    if (useChevronIcon) {
      handleChevron(e);
    }

    toggleOpen();
  };

  const handleChevron = (e) => {
    const chevronElement = e.currentTarget.querySelector('.react-chevron');
    if (chevronElement) {
      handleChevronClass(chevronElement);
    }
  }

  const handleChevronClass = (chevron) => {
    if (chevron.classList.contains('rotate-180') && !open) {
      chevron.classList.remove('rotate-180');
      return;
    }
    chevron.classList.add('rotate-180');
  };

  const { open, toggleOpen } = useClickToggleBySelector(false, parentElement, handler, false);

  if (!open) {
    return null;
  }

  return (
    <div className="absolute inset-x-0 top-full mt-1 bg-white rounded-lg px-4 py-2 border border-gray-200 shadow-lg w-full">
      {children}
    </div>
  );
}

export default Dropdown;
