const TableRow = ({ row, rowIndex }) => {
    return (
        <tr key={rowIndex} className="border-b border-gray-100 last:border-b-0">
            {row.map((cell, cellIndex) => (
                <td key={cellIndex} className="px-4 py-3 font-normal text-sm whitespace-nowrap">
                    {cell}
                </td>
            ))}
        </tr>
    );
}
export default TableRow;
