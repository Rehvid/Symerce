import React from 'react';

interface OrderLabelValueProps {
  icon?: JSX.Element | null
  label: string,
  value?: string | number | null
}

const LabelValue: React.FC<OrderLabelValueProps> = ({label, value, icon}) => (
  <div className="flex items-center gap-1.5">
    {icon && (icon)}
    <span className="text-sm font-normal">{label}:</span>
    <span className="break-all text-sm text-gray-500">{value ?? '-'}</span>
  </div>
)

export default LabelValue;
