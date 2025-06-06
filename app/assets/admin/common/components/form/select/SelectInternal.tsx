import React from 'react';
import { useDropdown } from '@admin/common/components/dropdown/DropdownContext';
import DropdownButton from '@admin/common/components/dropdown/DropdownButton';
import DropdownContent from '@admin/common/components/dropdown/DropdownContent';
import Badge from '@admin/common/components/Badge';
import ChevronIcon from '@/images/icons/chevron.svg';
import CheckIcon from '@/images/icons/check.svg';

interface Option<T = string | number | null> {
  label: string;
  value: T;
}

interface SelectProps<T = string | number | null> {
  options: Option<T>[];
  selected: T;
  onChange: (value: T) => void;
  hasError?: boolean;
  errorMessage?: string;
  dropdownContainerClasses?: string;
  usePlaceholderOption?: boolean;
}

const SelectInternal = <T extends string | number | null>({
    options,
    selected,
    onChange,
    hasError = false,
    errorMessage = '',
    dropdownContainerClasses = '',
    usePlaceholderOption = true,
  }: SelectProps<T>) => {
  const { isOpen, close } = useDropdown();

  const handleSelect = (value: T) => {
    onChange(value);
    close();
  };

  const selectedLabel = options.find(o => o.value === selected)?.label;
  const opts = usePlaceholderOption
    ? ([{ label: 'Wybierz...', value: null as T }] as Option<T>[]).concat(options)
    : options;

  return (
    <>
      <DropdownButton
        className={`min-h-[46px] w-full px-2.5 rounded-lg border border-gray-200 bg-white py-2.5  flex gap-2 items-center justify-between transition-all duration-300 cursor-pointer  ${hasError ? 'border-red-500 focus:ring-red-100' : 'border-gray-300'}  `}
      >
        <span>
          {selectedLabel ? (
            <Badge variant="success">{selectedLabel}</Badge>
          ) : (
            <span className="text-gray-400">Wybierz...</span>
          )}
        </span>
        <ChevronIcon
          className={`${isOpen ? 'rotate-180' : 'rotate-0'} w-[24px] h-[24px] transition-transform duration-300 text-gray-500`}
        />
      </DropdownButton>

      <DropdownContent containerClasses={`w-full  mt-2 ${dropdownContainerClasses}`}>
        <ul className="flex flex-col">
          {opts.map((opt, idx) => {
            const isSelected = selected === opt.value;
            return (
                <li key={idx} className="mt-2">
                  <div
                    onClick={() => handleSelect(opt.value)}
                    className={`flex gap-2 items-center justify-between cursor-pointer py-2 px-4 rounded-lg transition-all duration-300 ${
                      isSelected ? 'bg-blue-100 text-blue-700 font-medium' : 'hover:bg-gray-100'
                    }`}
                  >
                    <span>
                      {opt.label}
                    </span>
                    {isSelected && (
                      <CheckIcon className="w-[24px] h-[24px] bg-blue-100" />
                    )}
                  </div>
                </li>
              )
          })}
        </ul>
      </DropdownContent>

      {hasError && (
        <p className="mt-1 text-red-600 text-sm">{errorMessage}</p>
      )}
    </>
  );
};

export default SelectInternal;
