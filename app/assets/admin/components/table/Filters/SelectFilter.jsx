import Select from '@/admin/components/form/controls/Select';

const SelectFilter = ({ filters, setFilters, nameFilter, options }) => {
    const onChange = (value) => {
        if (null === value) {
            // eslint-disable-next-line no-unused-vars
            const { [nameFilter]: _, ...rest } = filters;
            setFilters({ ...rest, page: 1 });
        } else {
            setFilters({
                ...filters,
                [nameFilter]: value,
                page: 1,
            });
        }
    };

    return (
        <div className="w-64">
            <Select name={nameFilter} selected={filters[nameFilter] ?? ''} onChange={onChange} options={options} />
        </div>
    );
};

export default SelectFilter;
