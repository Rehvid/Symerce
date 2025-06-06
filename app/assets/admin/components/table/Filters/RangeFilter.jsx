import Input from '@/admin/components/form/controls/Input';
import { useState } from 'react';
import Heading from '@admin/common/components/Heading';
import NumberIcon from '@/images/icons/number.svg';

const RangeFilter = ({ filters, setFilters, nameFilter, label, icon = null }) => {
    const nameFilterFrom = `${nameFilter}From`;
    const nameFilterTo = `${nameFilter}To`;

    const [fromValue, setFromValue] = useState(filters[nameFilterFrom] ?? '');
    const [toValue, setToValue] = useState(filters[nameFilterTo] ?? '');

    const handleFilters = (newPartial) => {
        const updatedFilters = { ...filters };

        if (newPartial.from !== undefined) {
            if (newPartial.from === '' || newPartial.from === null) {
                delete updatedFilters[nameFilterFrom];
            } else {
                updatedFilters[nameFilterFrom] = newPartial.from;
            }
        }

        if (newPartial.to !== undefined) {
            if (newPartial.to === '' || newPartial.to === null) {
                delete updatedFilters[nameFilterTo];
            } else {
                updatedFilters[nameFilterTo] = newPartial.to;
            }
        }

        setFilters({ ...updatedFilters, page: 1 });
    };

    const forChange = (e) => {
        const newVal = e.target.value.trim();
        setFromValue(newVal);
        handleFilters({ from: newVal });
    };

    const toChange = (e) => {
        const newVal = e.target.value.trim();
        setToValue(newVal);
        handleFilters({ to: newVal });
    };

    const renderLabel = () => (
        <Heading level="h4" additionalClassNames={`mb-2 flex gap-2 `}>
            {icon}
            {label}
        </Heading>
    );

    return (
        <>
            {label && renderLabel()}
            <div className="flex flex-col lg:flex-row gap-4 items-center ">
                <Input
                    onChange={forChange}
                    value={fromValue}
                    placeholder="Od"
                    id={`${nameFilter}From`}
                    type="number"
                    icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]"  />}
                />
                <div className="hidden lg:block">-</div>
                <Input
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
