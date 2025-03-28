import TrashIcon from '../../../../../images/shared/trash.svg';
import AppButton from "../../../Common/AppButton";

const TableRowDeleteAction = ({ onClick }) => {
    return (
        <AppButton onClick={onClick} additionalClasses="text-gray-500">
            <TrashIcon />
        </AppButton>
    );
}

export default TableRowDeleteAction;
