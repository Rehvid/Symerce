import AppLink from '../../../Common/AppLink';
import PencilIcon from '../../../../../images/shared/pencil.svg';

const TableRowEditAction = ({ to }) => {
    return (
        <AppLink to={to} additionalClasses="text-gray-500">
            <PencilIcon />
        </AppLink>
    );
};

export default TableRowEditAction;
