import React from 'react';
import ZoomInIcon from '@/images/icons/zoom-in.svg';
import Link from '@admin/common/components/Link';

interface TableRowDetailActionProps {
    to?: string;
}

const TableRowDetailAction: React.FC<TableRowDetailActionProps> = ({ to }) => {
    if (!to) return null;

    return (
        <Link
            to={to}
            additionalClasses="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 hover:bg-gray-300 text-gray-600 hover:text-gray-900 transition-colors"
            title="Zobacz szczegóły"
            aria-label="Zobacz szczegóły"
        >
            <ZoomInIcon className="h-5 w-5" />
        </Link>
    );
};

export default TableRowDetailAction;
