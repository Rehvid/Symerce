import Link from '../../Link';
import PencilIcon from '../../../../../images/icons/pencil.svg';
import { FC } from 'react';

interface TableRowEditActionProps {
    to: string;
}

const TableRowEditAction: FC<TableRowEditActionProps> = ({ to }) => (
    <Link
        to={to}
        aria-label="Edit item"
        additionalClasses="inline-flex items-center justify-center w-8 h-8 rounded bg-blue-100 hover:bg-blue-200 transition-colors"
    >
        <PencilIcon className="w-5 h-5 text-blue-600" />
    </Link>
);

export default TableRowEditAction;
