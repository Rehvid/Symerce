import SearchIcon from '../../../../../../images/icons/search.svg';
import Input from '@admin/components/form/controls/Input';
import { useCallback, useState } from 'react';

const SearchFilter = ({ filters, setFilters }) => {
  const [inputValue, setInputValue] = useState(filters?.search || '');

  const onInputChange = (e) => {
    setInputValue(e.target.value);
  };

  const onSearchClick = () => {
    const value = inputValue.trim();

    if (value === '' && filters?.search) {
      const { search, ...rest } = filters;
      setFilters(rest);
    } else if (value !== '') {
      setFilters((prev) => ({
        ...prev,
        search: value,
      }));
    }
  };

    return (
        <Input
            onChange={onInputChange}
            type="text"
            value={inputValue}
            icon={<SearchIcon className="text-gray-500 w-[24px] h-[24px] cursor-pointer" onClick={onSearchClick} />}
            placeholder="Szukaj"
            id="search"
            containerClassName="w-full"
            onKeyDown={(e) => {
              if (e.key === 'Enter') {
                onSearchClick();
              }
            }}
        />
    );
};

export default SearchFilter;
