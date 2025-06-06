import Select from '@admin/components/form/controls/Select';
import { useState } from 'react';

const SelectFilter = ({ filters, setFilters, nameFilter, options, label = '' }) => {
    const [selected, setSelected] = useState(filters[nameFilter] ?? '');

    const onChange = (value) => {
        if (null === value) {
            // eslint-disable-next-line no-unused-vars
            const { [nameFilter]: _, ...rest } = filters;
            setFilters({ ...rest, page: 1 });

            setSelected(null);
        } else {
            setFilters({
                ...filters,
                [nameFilter]: value,
                page: 1,
            });
            setSelected(value);
        }
    };

    return <Select name={nameFilter} selected={selected} onChange={onChange} options={options} label={label} />;
};

export default SelectFilter;
