import Select from '@/admin/components/form/controls/Select';

export const PAGINATION_FILTER_DEFAULT_OPTION = 10;

const PaginationFilter = ({ filters, setFilters, overrideDefaultOptions = false, options = [{}] }) => {
    const defaultOptions = [
        { value: 10, label: 10 },
        { value: 25, label: 25 },
        { value: 50, label: 50 },
        { value: 100, label: 100 },
        { value: -1, label: 'Wszystkie' },
    ];

    const onChange = (value) => {
        setFilters({
            ...filters,
            limit: value,
            page: 1,
        });
    };

    return (
        <div className="max-w-48 w-full">
            <Select
                name="limit"
                selected={Number(filters.limit) || PAGINATION_FILTER_DEFAULT_OPTION}
                onChange={onChange}
                options={overrideDefaultOptions ? options : defaultOptions}
                usePlaceholderOption={false}
            />
        </div>
    );
};

export default PaginationFilter;
