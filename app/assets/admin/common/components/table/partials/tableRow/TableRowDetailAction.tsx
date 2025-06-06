import React from 'react';
import ZoomInIcon from '@/images/icons/zoom-in.svg';
import Link from '@admin/common/components/Link';

interface TableRowShowActionProps {
  to?: string
}

const TableRowShowAction: React.FC<TableRowShowActionProps> = ({ to }) => {
  if (to) {
    return (
      <Link to={to} additionalClasses="text-gray-500">
        <ZoomInIcon className="h-[24px] w-[24px]"  />
      </Link>
    )
  }

}

export default TableRowShowAction;
