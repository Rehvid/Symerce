import TableToolbar from './TableToolbar';
import TableColumns from './TableColumns';
import TableBody from './TableBody';

const Table = ({
    filters,
    setFilters,
    columns = [],
    data = [],
    actionButtons = null,
    titleSection = null,
    additionalFilters = [],
    children,
}) => {
    return (
        <div className="py-5">
            <div className="rounded-xl border border-gray-200 bg-white">
                <div className="p-6 border-gray-100">
                    <div className="space-y-6">
                        <TableToolbar
                            actionButtons={actionButtons}
                            titleSection={titleSection}
                            filters={filters}
                            setFilters={setFilters}
                            additionalFilters={additionalFilters}
                        />
                        <div className="py-2">
                            <div className="max-w-full overflow-x-auto mb-0 ">
                                <table className="min-w-full">
                                    <TableColumns columns={columns} />
                                    <TableBody data={data} />
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
