import EyeIcon from '@/images/icons/eye.svg';

const TableRowShowAction = ({href}) => (
  <a href={href} className="text-sm text-gray-500 hover:text-primary"  target="_blank" rel="noopener noreferrer">
    <EyeIcon className="w-[24px] h-[24px]" />
  </a>
)

export default TableRowShowAction;
