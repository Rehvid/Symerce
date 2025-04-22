import Heading from '@/admin/components/common/Heading';

const Select = ({ options, selected, name, onChange, label, id }) => {
    return (
        <div>
            {label && (
                <label htmlFor={id || 'input-id'} className="mb-2 block">
                    <Heading level="h4">{label}</Heading>
                </label>
            )}
            <select
                name={name}
                value={selected.value}
                onChange={onChange}
                id={id}
                className="border border-gray-300 text-gray-900 text-sm rounded-lg w-full py-2 px-4"
            >
                <option value="">Wybierz...</option>
                {options.map((option) => (
                    <option key={option.value} value={option.value}>
                        {option.label}
                    </option>
                ))}
            </select>
        </div>
    );
};
export default Select;
