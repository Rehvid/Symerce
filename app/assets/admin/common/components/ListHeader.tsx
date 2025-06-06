import React from 'react';
import Badge, { BadgeVariant } from '@admin/common/components/Badge';

interface ListHeaderProps {
    title: string;
    totalItems: number | string;
}

const ListHeader: React.FC<ListHeaderProps> = ({ title, totalItems }) => (
    <div className="flex items-center justify-center gap-2">
        <span>{title}</span>
        <Badge variant={BadgeVariant.Info}>{totalItems}</Badge>
    </div>
);

export default ListHeader;
