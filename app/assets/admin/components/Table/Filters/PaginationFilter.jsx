import Select from '../../../../shared/components/Select';

const PaginationFilter = ({ filters, setFilters, overrideDefaultOptions = false, options = [{}] }) => {
    const defaultOptions = [
        { value: '5', label: '5' },
        { value: '10', label: '10' },
        { value: '25', label: '25' },
        { value: '50', label: '50' },
    ];

    const onChange = e => {
        setFilters({
            ...filters,
            limit: e.target.value,
            page: 1,
        });
    };

    return (
        <div className="flex items-center gap-3">
            <span className="text-gray-500">Show</span>
            <Select
                name="limit"
                selected={filters.limit || 10}
                onChange={onChange}
                options={overrideDefaultOptions ? options : defaultOptions}
            />
        </div>
    );
};

export default PaginationFilter;
