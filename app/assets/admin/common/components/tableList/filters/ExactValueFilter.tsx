import React, { ChangeEvent, ReactNode, useState, useEffect } from 'react';
import Input from '@admin/components/form/controls/Input';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import NumberIcon from '@/images/icons/number.svg';
import InputField from '@admin/common/components/form/input/InputField';
import { TableFilters } from '@admin/common/interfaces/TableFilters';


interface ExactValueFilterProps<T extends TableFilters>   {
    filters: T;
    setFilters: React.Dispatch<React.SetStateAction<T>>
    nameFilter: keyof T & string;
    label?: string;
    icon?: ReactNode;
}

const ExactValueFilter = <T extends TableFilters> ({
    filters,
    setFilters,
    nameFilter,
    label = '',
    icon = null,
}: ExactValueFilterProps<T>): React.ReactElement => {
    const filterValue = filters[nameFilter];
    const initialValue = filterValue !== undefined && filterValue !== null
        ? String(filterValue)
        : '';

    const [exactValue, setExactValue] = useState<string>(initialValue);


    useEffect(() => {
        const value = filters[nameFilter];
        setExactValue(value !== undefined && value !== null ? String(value) : '');
    }, [filters, nameFilter]);

    const onChange = (e: ChangeEvent<HTMLInputElement>) => {
        const trimValue = e.target.value.trim();
        setExactValue(trimValue);

        if (trimValue === '') {
            const newFilters = { ...filters } as any;
            delete newFilters[nameFilter];
            setFilters({ ...newFilters, page: 1 } as T);
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
