import TrashIcon from '../../../../../images/icons/trash.svg';
import AppButton from '../../../common/AppButton';

const TableRowDeleteAction = ({ onClick }) => {
    return (
        <AppButton onClick={onClick} additionalClasses="text-gray-500">
            <TrashIcon />
        </AppButton>
    );
};

export default TableRowDeleteAction;
