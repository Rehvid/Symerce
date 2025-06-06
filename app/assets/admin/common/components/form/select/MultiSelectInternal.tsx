import React, { ChangeEvent } from 'react';
import { useDropdown } from '@admin/common/components/dropdown/DropdownContext';
import DropdownButton from '@admin/common/components/dropdown/DropdownButton';
import DropdownContent from '@admin/common/components/dropdown/DropdownContent';
import Badge from '@admin/common/components/Badge';
import ChevronIcon from '@/images/icons/chevron.svg';
import CheckIcon from '@/images/icons/check.svg';

type Option = { label: string; value: string | number };

interface MultiSelectProps {
  options: Option[];
  selected: (string | number)[];
  onChange: (value: string | number, checked: boolean) => void;
  hasError?: boolean;
  errorMessage?: string;
  contentClasses?: string;
}

export const MultiSelectInternal = <T extends string | number>({
   options,
   selected,
   onChange,
   hasError = false,
   errorMessage = '',
   contentClasses = '',
}: MultiSelectProps) => {
  const { isOpen } = useDropdown();

  const handleToggle = (value: string | number) => {
    const checked = selected.includes(value);
    onChange(value, !checked);
  };

  const selectedLabels = selected
    .map(val => options.find(opt => opt.value === val)?.label)
    .filter(Boolean) as string[];

  return (
    <>
      <DropdownButton
        className={`min-h-[46px] w-full px-2.5 rounded-lg border border-gray-200 bg-white py-2.5  flex gap-2 items-center justify-between transition-all duration-300 cursor-pointer  ${hasError ? 'border-red-500 focus:ring-red-100' : 'border-gray-300'}  `}
      >
        <span className="flex flex-wrap gap-2">
          {selectedLabels.length
            ? selectedLabels.map((lab, i) => <Badge key={i}>{lab}</Badge>)
            : <span className="text-gray-400">Wybierz...</span>}
        </span>
        <ChevronIcon
          className={`${isOpen ? 'rotate-180' : 'rotate-0'} w-[24px] h-[24px] transition-transform duration-300 text-gray-500`}
        />
      </DropdownButton>

      <DropdownContent containerClasses={`w-full  mt-2 ${contentClasses}`}>
        <ul className="flex flex-col">
          {options.map(opt => {
            const checked = selected.includes(opt.value);
            return (
              <li key={opt.value} className="mt-2">
                <div
                  onClick={() => handleToggle(opt.value)}
                  className={`flex gap-2 items-center justify-between cursor-pointer py-2 px-4 rounded-lg transition-all duration-300 ${
                    checked ? 'bg-blue-100 text-blue-700 font-medium' : 'hover:bg-gray-100'
                  }`}
                >
                  <span>
                      {opt.label}
                    </span>
                  {checked && (
                    <CheckIcon className="w-[24px] h-[24px] bg-blue-100" />
                  )}
                </div>
              </li>
            );
          })}
        </ul>
      </DropdownContent>

      {hasError && (
        <p className="mt-1 text-red-600 text-sm">{errorMessage}</p>
      )}
    </>
  );
};
