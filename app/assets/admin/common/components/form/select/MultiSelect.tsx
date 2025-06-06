import React from 'react';
import Dropdown from '@admin/common/components/dropdown/Dropdown';
import { MultiSelectInternal } from '@admin/common/components/form/select/MultiSelectInternal';


type Option = { label: string; value: string | number };

export const MultiSelect = <T extends string | number>(props: {
  options: Option[];
  selected: T[];
  onChange: (value: T, checked: boolean) => void;
  hasError?: boolean;
  errorMessage?: string;
  buttonClasses?: string;
  contentClasses?: string;
}) => (
  <Dropdown>
    <MultiSelectInternal {...props} />
  </Dropdown>
);

export default MultiSelect;
