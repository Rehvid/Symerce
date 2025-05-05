import TableToolbar from './TableToolbar';
import TableColumns from './TableColumns';
import TableBody from './TableBody';

const Table = ({
    filters,
    setFilters,
    additionalToolbarContent = '',
    defaultFilters = {},
    columns = [],
    data = [],
    additionalFilters = [],
    useDraggable = false,
    draggableCallback = {},
    pagination = {},
    sort = {},
    setSort = false,
    children,
}) => {
    return (
        <div className="rounded-xl border border-gray-200 bg-white my-6">
            <div className="p-6 space-y-6">
                <TableToolbar
                    filters={filters}
                    setFilters={setFilters}
                    additionalFilters={additionalFilters}
                    additionalToolbarContent={additionalToolbarContent}
                    sort={sort}
                    setSort={setSort}
                    defaultFilters={defaultFilters}
                />
                <div className="overflow-x-auto mb-0">
                    <table className="w-full table-auto">
                        <TableColumns columns={columns} sort={sort} setSort={setSort} />
                        <TableBody
                            data={data}
                            useDraggable={useDraggable}
                            draggableCallback={draggableCallback}
                            pagination={pagination}
                            filters={filters}
                        />
                    </table>
                </div>
                {children && children}
            </div>
        </div>
    );
};

export default Table;
