import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import Badge from '@/admin/components/common/Badge';
import ListHeader from '@/admin/components/ListHeader';
import useDraggable from '@/admin/hooks/useDraggable';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';
import { filterEmptyValues } from '@/admin/utils/helper';
import SelectFilter from '@/admin/components/table/Filters/SelectFilter';
import RangeFilter from '@/admin/components/table/Filters/RangeFilter';

const DeliveryTimeList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(
        filterEmptyValues({
            ...defaultFilters,
            type: getCurrentParam('type', (value) => value),
            minDaysFrom: getCurrentParam('minDaysFrom', (value) => Number(value)),
            minDaysTo: getCurrentParam('minDaysTo', (value) => Number(value)),
            maxDaysFrom: getCurrentParam('maxDaysFrom', (value) => Number(value)),
            maxDaysTo: getCurrentParam('maxDaysTo', (value) => Number(value)),
        }),
    );

    const { draggableCallback } = useDraggable('admin/delivery-time/order');
    const { items, pagination, isLoading, removeItem, sort, setSort, additionalData } = useListData(
        'admin/delivery-time',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, label, minDays, maxDays, type } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            label,
            minDays,
            maxDays,
            type: <Badge variant="info"> {type} </Badge>,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/delivery-time/${id}`)} />,
        });
    });

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'label', label: 'Nazwa', sortable: true },
        { orderBy: 'minDays', label: 'Minimalne Dni', sortable: true },
        { orderBy: 'maxDays', label: 'Maksymalne Dni', sortable: true },
        { orderBy: 'type', label: 'Typ', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    const additionalFilters = [
        <SelectFilter
            setFilters={setFilters}
            filters={filters}
            nameFilter="type"
            options={additionalData?.types || []}
            label="Typy"
        />,
        <RangeFilter setFilters={setFilters} filters={filters} label="Minimalne Dni" nameFilter="minDays" />,
        <RangeFilter setFilters={setFilters} filters={filters} label="Maksymalne Dni" nameFilter="maxDays" />,
    ];

    const additionalToolbarContent = (
        <PageHeader title={<ListHeader title="Czasy dostawy" totalItems={pagination.totalItems} />}>
            <TableToolbarButtons />
        </PageHeader>
    );

    return (
        <DataTable
            filters={filters}
            setFilters={setFilters}
            columns={columns}
            items={data}
            pagination={pagination}
            additionalFilters={additionalFilters}
            useDraggable={true}
            draggableCallback={draggableCallback}
            sort={sort}
            setSort={setSort}
            defaultFilters={defaultFilters}
            additionalToolbarContent={additionalToolbarContent}
        />
    );
};

export default DeliveryTimeList;
