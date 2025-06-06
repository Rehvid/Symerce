import Link from '../../../../common/components/Link';
import PencilIcon from '../../../../../images/icons/pencil.svg';

const TableRowEditAction = ({ to }) => {
    return (
        <Link to={to} additionalClasses="text-gray-500">
            <PencilIcon className="w-[24px] h-[24px]" />
        </Link>
    );
};

export default TableRowEditAction;
