import TableRow from './TableRow';

function TableBody({ data }) {
    return (
        <tbody>
            {data.map((row, rowIndex) => (
                <TableRow key={rowIndex} row={row} rowIndex={rowIndex} />
            ))}
        </tbody>
    );
}

export default TableBody;
