import Select from '@/shared/components/Select';

export const PAGINATION_FILTER_DEFAULT_OPTION = 10;

const PaginationFilter = ({ filters, setFilters, overrideDefaultOptions = false, options = [{}] }) => {
    const defaultOptions = [
        { value: '10', label: '10' },
        { value: '25', label: '25' },
        { value: '50', label: '50' },
    ];

    const onChange = (e) => {
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
                selected={filters.limit || PAGINATION_FILTER_DEFAULT_OPTION}
                onChange={onChange}
                options={overrideDefaultOptions ? options : defaultOptions}
            />
        </div>
    );
};

export default PaginationFilter;
