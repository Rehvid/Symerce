import React, { ChangeEvent, useEffect, useState } from 'react';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import NumberIcon from '@/images/icons/number.svg';
import { TableFilters } from '@admin/common/interfaces/TableFilters';
import InputField from '@admin/common/components/form/input/InputField';

interface RangeFilterProps<T extends TableFilters> {
    filters: T;
    setFilters: React.Dispatch<React.SetStateAction<T>>;
    nameFilter: string;
    label?: string;
    icon?: React.ReactElement | null;
}

interface FilterPartial {
    from?: string | null;
    to?: string | null;
}


const RangeFilter = <T extends TableFilters>({
    filters,
    setFilters,
    nameFilter,
    label,
    icon = null,
}: RangeFilterProps<T>): React.ReactElement => {
    const nameFilterFrom = `${nameFilter}From` as keyof T;
    const nameFilterTo = `${nameFilter}To` as keyof T;
    const fromFilterValue = filters[nameFilterFrom];
    const toFilterValue = filters[nameFilterTo];

    const [fromValue, setFromValue] = useState<string>(
        fromFilterValue !== undefined && fromFilterValue !== null
            ? String(fromFilterValue)
            : ''
    );
    const [toValue, setToValue] = useState<string>(
        toFilterValue !== undefined && toFilterValue !== null
            ? String(toFilterValue)
            : ''
    );


    useEffect(() => {
        setFromValue(
            filters[nameFilterFrom] !== undefined && filters[nameFilterFrom] !== null
                ? String(filters[nameFilterFrom])
                : ''
        );

        setToValue(
            filters[nameFilterTo] !== undefined && filters[nameFilterTo] !== null
                ? String(filters[nameFilterTo])
                : ''
        );
    }, [filters, nameFilterFrom, nameFilterTo]);

    const handleFilters = (newPartial: FilterPartial): void => {
        const updatedFilters = { ...filters } as Record<string, any>;

        if (newPartial.from !== undefined) {
            if (newPartial.from === '' || newPartial.from === null) {
                delete updatedFilters[nameFilterFrom as string];
            } else {
                updatedFilters[nameFilterFrom as string] = Number(newPartial.from);
            }
        }

        if (newPartial.to !== undefined) {
            if (newPartial.to === '' || newPartial.to === null) {
                delete updatedFilters[nameFilterTo as string];
            } else {
                updatedFilters[nameFilterTo as string] = Number(newPartial.to);
            }
        }

        setFilters({ ...updatedFilters, page: 1 } as T);
    };


    const forChange = (e: ChangeEvent<HTMLInputElement>): void => {
        const newVal: string = e.target.value.trim();
        setFromValue(newVal);
        handleFilters({ from: newVal });
    };

    const toChange = (e: ChangeEvent<HTMLInputElement>): void => {
        const newVal: string = e.target.value.trim();
        setToValue(newVal);
        handleFilters({ to: newVal });
    };

    const renderLabel = (): React.ReactElement => (
        <Heading level={HeadingLevel.H4} additionalClassNames={`mb-2 flex gap-2 `}>
            {icon}
            {label}
        </Heading>
    );

    return (
        <>
            {label && renderLabel()}
            <div className="flex flex-col lg:flex-row gap-4 items-center ">
                <InputField
                    onChange={forChange}
                    value={fromValue}
                    placeholder="Od"
                    id={`${nameFilter}From`}
                    type="number"
                    icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
                <div className="hidden lg:block">-</div>
                <InputField
                    onChange={toChange}
                    value={toValue}
                    placeholder="Do"
                    id={`${nameFilter}To`}
                    type="number"
                    icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
            </div>
        </>
    );
};

export default RangeFilter;
