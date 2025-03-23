import Select from '../../../../shared/components/Select';

function PaginationFilter({ filters, setFilters, overrideDefaultOptions = false, options = [{}] }) {
    const defaultOptions = [
        { value: '2', label: '2' },
        { value: '4', label: '4' },
        { value: '6', label: '6' },
    ];

    const onChange = e => {
        setFilters({
            ...filters,
            perPage: e.target.value,
            page: 1,
        });
    };

    return (
        <div className="flex items-center gap-3">
            <span className="text-gray-500">Show</span>
            <Select
                name="perPage"
                selected={filters.perPage || 2}
                onChange={onChange}
                options={overrideDefaultOptions ? options : defaultOptions}
            />
        </div>
    );
}

export default PaginationFilter;
