import React from 'react';
import Dropdown from '@admin/common/components/dropdown/Dropdown';
import SelectInternal from '@admin/common/components/form/select/SelectInternal';

const Select = <T extends string | number | null>(
  props: React.ComponentProps<typeof SelectInternal>
) => (
  <Dropdown>
    <SelectInternal {...props} />
  </Dropdown>
);

export default Select;
