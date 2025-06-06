import Badge from '@admin/common/components/Badge';

const TableRowActiveBadge = ({ isActive }) => {
    const variant = isActive ? 'success' : 'error';
    const text = isActive ? 'Aktywny' : 'Nieaktywny';

    return <Badge variant={variant}>{text}</Badge>;
};

export default TableRowActiveBadge;
