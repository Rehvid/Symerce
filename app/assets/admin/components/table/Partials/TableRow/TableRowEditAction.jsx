import AppLink from '../../../common/AppLink';
import PencilIcon from '../../../../../images/icons/pencil.svg';

const TableRowEditAction = ({ to }) => {
    return (
        <AppLink to={to} additionalClasses="text-gray-500">
            <PencilIcon className="w-[24px] h-[24px]" />
        </AppLink>
    );
};

export default TableRowEditAction;
