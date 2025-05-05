import Table from '@/admin/components/table/Table';
import TablePagination from '@/admin/components/table/TablePagination';

const DataTable = ({
    filters,
    setFilters,
    defaultFilters,
    columns,
    items,
    pagination,
    additionalFilters,
    additionalToolbarContent,
    useDraggable,
    draggableCallback,
    sort = {},
    setSort,
}) => {
    return (
        <Table
            filters={filters}
            setFilters={setFilters}
            defaultFilters={defaultFilters}
            additionalFilters={additionalFilters}
            columns={columns}
            additionalToolbarContent={additionalToolbarContent}
            data={items}
            useDraggable={useDraggable}
            draggableCallback={draggableCallback}
            sort={sort}
            setSort={setSort}
            pagination={pagination}
        >
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination} />
        </Table>
    );
};
export default DataTable;
