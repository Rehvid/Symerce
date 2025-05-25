const TableRowMoney = ({ amount, symbol }) => (
  <strong>
      {amount && symbol ? `${amount} ${symbol}` : '-'}
  </strong>
);

export default TableRowMoney;
