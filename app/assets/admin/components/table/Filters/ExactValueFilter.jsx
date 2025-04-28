import { useState } from 'react';
import Dropdown from '@/admin/components/dropdown/Dropdown';
import DropdownButton from '@/admin/components/dropdown/DropdownButton';
import ChevronIcon from '@/images/icons/chevron.svg';
import DropdownContent from '@/admin/components/dropdown/DropdownContent';
import Input from '@/admin/components/form/controls/Input';
import Badge from '@/admin/components/common/Badge';

const ExactValueFilter = ({filters, setFilters, nameFilter, label = '', icon = null}) => {
  const [openDropdown, setOpenDropdown] = useState(false);

  const renderValueBadge = () => {
    const filterItem = filters[nameFilter];

    if (filterItem !== null && filterItem !== '' && filterItem !== undefined) {
      return  (<Badge variant="info">{filters[nameFilter]}</Badge>);
    }

    return (<span>{label}</span>)
  }

  const onChange = (e) => {
    const trimValue = e.target.value.trim();
    if (trimValue === '') {
      const { [nameFilter]: _, ...rest } = filters;
      setFilters({ ...rest, page: 1 });
    } else {
      setFilters({
        ...filters,
        [nameFilter]: trimValue,
        page: 1,
      });
    }
  };

  return (
    <Dropdown>
      <DropdownButton
        className={`h-[46px] px-2.5 w-64 rounded-lg border border-gray-300 bg-white flex gap-2 items-center justify-between transition-all duration-300 cursor-pointer  `}
        onClickExtra={() => setOpenDropdown((value) => !value)}
      >
        <span className="flex gap-2 flex-wrap text-gray-400">
          {icon && (icon)}
          {renderValueBadge()}

        </span>
        <ChevronIcon
          className={`${openDropdown ? 'rotate-180' : 'rotate-0'} transition-transform duration-300 text-gray-500`}
        />
      </DropdownButton>
      <DropdownContent containerClasses="w-full mt-2">
        <div className="flex flex-col gap-4">
          {label}
          <Input onChange={onChange} value={filters[nameFilter] ?? ''} placeholder={label}  />
        </div>
      </DropdownContent>
    </Dropdown>
  );
}

export default ExactValueFilter;
