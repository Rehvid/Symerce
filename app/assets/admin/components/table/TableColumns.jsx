const TableColumns = ({ columns }) => {
    return (
        <thead className="bg-gray-50 border-b border-gray-100">
            <tr>
                {columns.map((col, index) => (
                    <th key={index} className="px-4 py-3" scope="col">
                        <div>
                            <p className="font-medium text-sm text-black">{col}</p>
                        </div>
                    </th>
                ))}
            </tr>
        </thead>
    );
};

export default TableColumns;
