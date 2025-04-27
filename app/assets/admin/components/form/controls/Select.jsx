import { useState } from 'react';
import Dropdown from '@/admin/components/dropdown/Dropdown';
import Heading from '@/admin/components/common/Heading';
import DropdownButton from '@/admin/components/dropdown/DropdownButton';
import Badge from '@/admin/components/common/Badge';
import ChevronIcon from '@/images/icons/chevron.svg';
import DropdownContent from '@/admin/components/dropdown/DropdownContent';

const Select = ({
    options,
    selected,
    label,
    isRequired,
    onChange,
    hasError,
    errorMessage,
    usePlaceholderOption = true,
}) => {
    const [openDropdown, setOpenDropdown] = useState(false);

    const handleSelect = (value) => {
        onChange(value);
    };

    const selectedLabel = options.find((opt) => opt.value === selected)?.label;
    const optionsWithPlaceholder = usePlaceholderOption ? [{ label: 'Wybierz...', value: null }, ...options] : options;

    return (
        <>
            <Dropdown>
                <Heading level="h4" additionalClassNames={`mb-2 ${hasError ? ' text-red-900' : ''}`}>
                    {label} {isRequired && <span className="pl-1 text-red-500">*</span>}
                </Heading>
                <DropdownButton
                    className={`h-[46px] px-2.5 rounded-lg border border-gray-300 bg-white py-2.5  flex gap-2 items-center justify-between transition-all duration-300 cursor-pointer  ${hasError ? 'border-red-500 focus:ring-red-100' : 'border-gray-300'}  `}
                    onClickExtra={() => setOpenDropdown((value) => !value)}
                >
                    <span className="flex gap-2 flex-wrap">
                        {selectedLabel ? (
                            <Badge>{selectedLabel}</Badge>
                        ) : (
                            <span className="text-gray-400">Wybierz...</span>
                        )}
                    </span>
                    <ChevronIcon
                        className={`${openDropdown ? 'rotate-180' : 'rotate-0'} transition-transform duration-300 text-gray-500`}
                    />
                </DropdownButton>
                <DropdownContent containerClasses="w-full mt-2">
                    <ul className="flex flex-col">
                        {optionsWithPlaceholder.map((option, key) => {
                            const isSelected = selected === option.value;
                            return (
                                <li key={key}>
                                    <div
                                        onClick={() => handleSelect(option.value)}
                                        className={`flex items-center cursor-pointer py-2 px-4 rounded-lg transition-all duration-300 ${
                                            isSelected ? 'bg-blue-100 text-blue-700 font-medium' : 'hover:bg-gray-100'
                                        }`}
                                    >
                                        <span className="mr-2 w-3 h-3 rounded-full border border-gray-400 flex items-center justify-center">
                                            {isSelected && <span className="w-2 h-2 bg-blue-500 rounded-full" />}
                                        </span>
                                        {option.label}
                                    </div>
                                </li>
                            );
                        })}
                    </ul>
                </DropdownContent>
            </Dropdown>
            {hasError && <p className="mt-2 pl-2 text-sm text-red-600">{errorMessage}</p>}
        </>
    );
};

export default Select;
