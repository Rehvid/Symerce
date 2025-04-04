import AppLink from '../../../common/AppLink';
import PencilIcon from '../../../../../images/icons/pencil.svg';

const TableRowEditAction = ({ to }) => {
    return (
        <AppLink to={to} additionalClasses="text-gray-500">
            <PencilIcon />
        </AppLink>
    );
};

export default TableRowEditAction;
