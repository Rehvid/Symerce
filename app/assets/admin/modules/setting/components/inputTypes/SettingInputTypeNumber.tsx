import NumberIcon from '@/images/icons/number.svg';
import InputField from '@admin/common/components/form/input/InputField';
import React from 'react';

const SettingInputTypeNumber = ({register}) => {
  return (
    <InputField
      type="number"
      id="value"
      icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
      {...register('value')}
    />
  )
}

export default SettingInputTypeNumber;
