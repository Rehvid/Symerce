import Input from '@/admin/components/form/controls/Input';
import { useState } from 'react';
import Dropdown from '@/admin/components/dropdown/Dropdown';
import DropdownButton from '@/admin/components/dropdown/DropdownButton';
import ChevronIcon from '@/images/icons/chevron.svg';
import DropdownContent from '@/admin/components/dropdown/DropdownContent';
import Badge from '@/admin/components/common/Badge';

const RangeFilter = ({ filters, setFilters, nameFilter, label, icon = null }) => {
    const [openDropdown, setOpenDropdown] = useState(false);

    const value = {
        from: filters[`${nameFilter}From`] ?? '',
        to: filters[`${nameFilter}To`] ?? '',
    };

    const handleFilters = (newPartial) => {
        const nameFilterFrom = `${nameFilter}From`;
        const nameFilterTo = `${nameFilter}To`;

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
        handleFilters({ from: e.target.value.trim() });
    };

    const toChange = (e) => {
        handleFilters({ to: e.target.value.trim() });
    };

    const renderValueBadge = () => {
        if (value.from !== null && value.from !== '' && value.to !== null && value.to !== '') {
            return (
                <>
                    <Badge variant="info">{value.from}</Badge> - <Badge variant="info">{value.to}</Badge>
                </>
            );
        }
        return <span>{label}</span>;
    };

    return (
        <Dropdown>
            <DropdownButton
                className={`h-[46px] px-2.5 w-64 rounded-lg border border-gray-300 bg-white flex gap-2 items-center justify-between transition-all duration-300 cursor-pointer  `}
                onClickExtra={() => setOpenDropdown((isOpen) => !isOpen)}
            >
                <span className="flex gap-2 flex-wrap text-gray-400">
                    {icon && icon}
                    {renderValueBadge()}
                </span>
                <ChevronIcon
                    className={`${openDropdown ? 'rotate-180' : 'rotate-0'} transition-transform duration-300 text-gray-500`}
                />
            </DropdownButton>
            <DropdownContent containerClasses="w-full mt-2">
                <div className="flex flex-col gap-4">
                    {label}
                    <Input onChange={forChange} value={value?.from || ''} placeholder="Od" />
                    <Input onChange={toChange} value={value?.to || ''} placeholder="Do" />
                </div>
            </DropdownContent>
        </Dropdown>
    );
};

export default RangeFilter;
