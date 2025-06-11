import React from 'react';
import SettingValueInputTypeSelect from '@admin/modules/setting/components/inputTypes/SettingValueInputTypeSelect';
import SettingValueInputTypeCheckbox from '@admin/modules/setting/components/inputTypes/SettingValueInputTypeCheckbox';
import SettingValueInputTypeRawTextarea from '@admin/modules/setting/components/inputTypes/SettingValueInputTypeRawTextarea';
import { Control, UseFormRegister } from 'react-hook-form';
import { SettingFormData } from '@admin/modules/setting/interfaces/SettingFormData';
import LabelNameIcon from '@/images/icons/label-name.svg';
import NumberIcon from '@/images/icons/number.svg';
import { SettingInputType } from '@admin/modules/setting/enums/settingInputType';
import SettingValueInputFieldType from '@admin/modules/setting/components/inputTypes/SettingValueInputFieldType';

interface SettingInputTypeProps {
    register: UseFormRegister<SettingFormData>
    control: Control<SettingFormData>
    formData: SettingFormData
}

const SettingValueInputType: React.FC<SettingInputTypeProps> = ({register, control, formData}) => {
  const settingField = formData.settingField;

  switch (settingField?.inputType) {
    case SettingInputType.SELECT:
      return (
        <SettingValueInputTypeSelect
          control={control}
          settingField={settingField}
          isMulti={false}
        />
      )
    case SettingInputType.MULTISELECT:
      return (
          <SettingValueInputTypeSelect
              control={control}
              settingField={settingField}
              isMulti={true}
          />
      )
    case SettingInputType.CHECKBOX:
      return (
        <SettingValueInputTypeCheckbox
          register={register}
        />
      )
    case SettingInputType.RAW_TEXTAREA:
      return (
        <SettingValueInputTypeRawTextarea register={register} />
      )
    case SettingInputType.TEXT:
      return (
        <SettingValueInputFieldType
            register={register}
            type="text"
            icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        />
      )
    case SettingInputType.NUMBER:
      return (
        <SettingValueInputFieldType
            register={register}
            type="number"
            icon={<NumberIcon className="text-gray-500 w-[16px] h-[16px]" />}
        />
      )
  }

  return null;
}

export default SettingValueInputType;
