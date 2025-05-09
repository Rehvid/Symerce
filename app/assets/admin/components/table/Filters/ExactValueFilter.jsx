import { useState } from 'react';
import Input from '@/admin/components/form/controls/Input';
import Heading from '@/admin/components/common/Heading';
import NumberIcon from '@/images/icons/number.svg';

const ExactValueFilter = ({ filters, setFilters, nameFilter, label = '', icon = null }) => {
    const [exactValue, setExactValue] = useState(filters[nameFilter] ?? '');

    const onChange = (e) => {
        const trimValue = e.target.value.trim();
        setExactValue(trimValue);
        if (trimValue === '') {
            // eslint-disable-next-line no-unused-vars
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
        <Heading level="h4" additionalClassNames={`mb-2 flex gap-2`}>
            {icon}
            {label}
        </Heading>
    );

    return (
        <>
            {label && renderLabel()}
            <div className="flex flex-col gap-4">
                <Input
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
