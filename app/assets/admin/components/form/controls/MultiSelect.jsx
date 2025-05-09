import Dropdown from '@/admin/components/dropdown/Dropdown';
import DropdownButton from '@/admin/components/dropdown/DropdownButton';
import DropdownContent from '@/admin/components/dropdown/DropdownContent';
import { useState } from 'react';
import Badge from '@/admin/components/common/Badge';
import ChevronIcon from '@/images/icons/chevron.svg';
import Heading from '@/admin/components/common/Heading';

const MultiSelect = ({ options, selected, label, isRequired, onChange, hasError, errorMessage }) => {
    const [openDropdown, setOpenDropdown] = useState(false);

    const handleCheckboxChange = (e) => {
        const { value, checked } = e.target;
        onChange(value, checked);
    };

    const selectedLabels = selected.map((value) => options.find((opt) => opt.value === value)?.label).filter(Boolean);

    return (
        <>
            <Dropdown>
                <Heading level="h4" additionalClassNames={`mb-2 ${hasError ? ' text-red-900' : ''}`}>
                    {label} {isRequired && <span className="pl-1 text-red-500">*</span>}
                </Heading>
                <DropdownButton
                    className={`min-h-[46px] px-2.5 rounded-lg border border-gray-300 bg-white py-2.5  flex gap-4 items-center justify-between transition-all duration-300 cursor-pointer  ${hasError ? 'border-red-500 focus:ring-red-100' : 'border-gray-300'}  `}
                    onClickExtra={() => setOpenDropdown((value) => !value)}
                >
                    <span className="flex gap-4 flex-wrap basis-[85%] ">
                        {selectedLabels.length > 0 ? (
                            selectedLabels.map((name, key) => <Badge key={key}>{name}</Badge>)
                        ) : (
                            <span className="text-gray-400">Wybierz...</span>
                        )}
                    </span>
                    <ChevronIcon
                        className={`${openDropdown ? 'rotate-180' : 'rotate-0'} w-[24px] h-[24px] transition-transform duration-300 text-gray-500`}
                    />
                </DropdownButton>
                <DropdownContent containerClasses="w-full mt-2">
                    <ul className="flex flex-col">
                        {options.map((option, key) => (
                            <li key={key}>
                                <label className="flex items-center hover:bg-gray-100 transition-all cursor-pointer py-2 px-4 duration-300 rounded-lg">
                                    <input
                                        className="mr-2 w-4 h-4 border-gray-300 rounded-lg text-blue-600 bg-gray-100 "
                                        type="checkbox"
                                        value={option.value}
                                        checked={selected.includes(option.value)}
                                        onChange={handleCheckboxChange}
                                    />
                                    {option.label}
                                </label>
                            </li>
                        ))}
                    </ul>
                </DropdownContent>
            </Dropdown>
            {hasError && <p className="mt-2 pl-2 text-sm text-red-600">{errorMessage}</p>}
        </>
    );
};

export default MultiSelect;
