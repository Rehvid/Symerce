import AppLink from '../../../Common/AppLink';
import TrashIcon from '../../../../../images/shared/trash.svg';

function TableRowDeleteAction({ to }) {
    return (
        <AppLink to={to} additionalClasses="text-gray-500">
            <TrashIcon />
        </AppLink>
    );
}

export default TableRowDeleteAction;
