import TableToolbar from './TableToolbar';
import TableColumns from './TableColumns';
import TableBody from './TableBody';

const Table = ({
    filters,
    setFilters,
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
        <div className="py-5">
            <div className="rounded-xl border border-gray-200 bg-white">
                <div className="p-6 border-gray-100">
                    <div className="space-y-6">
                        <TableToolbar
                            filters={filters}
                            setFilters={setFilters}
                            additionalFilters={additionalFilters}
                            sort={sort}
                            setSort={setSort}
                            defaultFilters={defaultFilters}
                        />
                        <div className="py-2">
                            <div className="max-w-full overflow-x-auto mb-0 ">
                                <table className="min-w-full">
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
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Table;
