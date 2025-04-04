import Table from '@/admin/components/table/Table';
import TableActionHeader from '@/admin/components/table/Partials/TableActionHeader';
import TablePagination from '@/admin/components/table/TablePagination';

const DataTable = ({ title, filters, setFilters, columns, items, pagination, additionalFilters, actionButtons }) => {
    return (
        <Table
            filters={filters}
            setFilters={setFilters}
            additionalFilters={additionalFilters}
            columns={columns}
            actionButtons={actionButtons}
            titleSection={<TableActionHeader title={title} total={pagination.totalItems} />}
            data={items}
        >
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination} />
        </Table>
    );
};
export default DataTable;
