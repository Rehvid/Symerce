import Table from '@/admin/components/table/Table';
import TablePagination from '@/admin/components/table/TablePagination';

const DataTable = ({
    filters,
    setFilters,
    columns,
    items,
    pagination,
    additionalFilters,
    actionButtons,
    useDraggable,
    draggableCallback,
    sortBy = [],
}) => {
    return (
        <Table
            filters={filters}
            setFilters={setFilters}
            additionalFilters={additionalFilters}
            columns={columns}
            actionButtons={actionButtons}
            data={items}
            useDraggable={useDraggable}
            draggableCallback={draggableCallback}
            sortBy={sortBy}
            pagination={pagination}
        >
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination} />
        </Table>
    );
};
export default DataTable;
