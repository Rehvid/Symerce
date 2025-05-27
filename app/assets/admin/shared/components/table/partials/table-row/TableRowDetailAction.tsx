import React from 'react';
import ZoomInIcon from '@/images/icons/zoom-in.svg';
import AppLink from '@admin/components/common/AppLink';

interface TableRowShowActionProps {
  to?: string
}

const TableRowShowAction: React.FC<TableRowShowActionProps> = ({ to }) => {
  if (to) {
    return (
      <AppLink to={to} additionalClasses="text-gray-500">
        <ZoomInIcon className="h-[24px] w-[24px]"  />
      </AppLink>
    )
  }

}

export default TableRowShowAction;
