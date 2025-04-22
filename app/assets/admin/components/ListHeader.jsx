import Badge from '@/admin/components/common/Badge';

const ListHeader = ({ title, totalItems }) => (
    <div className="flex items-center justify-center gap-2">
        <span>{title}</span>
        <Badge variant="info">{totalItems}</Badge>
    </div>
);

export default ListHeader;
