import LabelNameIcon from '@/images/icons/label-name.svg';
import InputField from '@admin/common/components/form/input/InputField';
import React from 'react';

const SettingInputTypeText = ({register}) => {
  return (
    <InputField
      type="text"
      id="value"
      icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
      {...register('value')}
    />
  )
}

export default SettingInputTypeText;
