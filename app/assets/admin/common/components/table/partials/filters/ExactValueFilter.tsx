import React, { ChangeEvent, ReactNode, useState } from 'react';
import Input from '@admin/components/form/controls/Input';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import NumberIcon from '@/images/icons/number.svg';
import InputField from '@admin/common/components/form/input/InputField';

interface FiltersType {
    [key: string]: any;
}

interface ExactValueFilterProps  {
    filters: FiltersType;
    setFilters: (filters: FiltersType) => void;
    nameFilter: string;
    label?: string;
    icon?: ReactNode;
}

const ExactValueFilter: React.FC<ExactValueFilterProps> = ({
    filters,
    setFilters,
    nameFilter,
    label = '',
    icon = null,
}) => {
    const [exactValue, setExactValue] = useState<string>(filters[nameFilter] ?? '');

    const onChange = (e: ChangeEvent<HTMLInputElement>) => {
        const trimValue = e.target.value.trim();
        setExactValue(trimValue);

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

    const renderLabel = () => (
        <Heading level={HeadingLevel.H4} additionalClassNames="mb-2 flex gap-2">
            {icon}
            {label}
        </Heading>
    );


    return (
        <>
            {label && renderLabel()}
            <div className="flex flex-col gap-4">
                <InputField
                    onChange={onChange}
                    value={exactValue}
                    placeholder={label}
                    type="number"
                    id={nameFilter}
                    icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
            </div>
        </>
    );
};

export default ExactValueFilter;
