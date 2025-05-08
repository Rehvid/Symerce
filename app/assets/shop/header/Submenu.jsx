import { useClickToggleBySelector } from '@/shop/hooks/useClickToggleBySelector';

const Submenu = ({items, parent}) => {
  const handler = (e) => {
    const chevronElement = e.currentTarget.querySelector('.react-chevron');

    if (chevronElement) {
      handleChevronClass(chevronElement);
    }

    toggleOpen();
  };

  const handleChevronClass = (chevron) => {
    if (chevron.classList.contains('rotate-180') && !open) {
      chevron.classList.remove('rotate-180');
      return;
    }
    chevron.classList.add('rotate-180');
  }

  const {open, toggleOpen } = useClickToggleBySelector(false, parent, handler, false);

  if (!open) {
    return null;
  }

  return (
    <div className="absolute bg-white rounded-lg px-4 py-2 border border-gray-200 shadow-lg w-full">
      <ul>
        {items.map((item, key) => (
          <li key={key}>
            <a className="flex items-center h-[46px] w-full transition-all duration-300 cursor-pointer hover:text-primary" href={item.url}>
              {item.label}
            </a>
          </li>
        ))}
      </ul>
    </div>
  )
}

export default Submenu;
