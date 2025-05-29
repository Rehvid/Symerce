import React from 'react';
import { SettingInputType } from '@admin/modules/setting/enums/settingInputType';
import SettingInputTypeSelect from '@admin/modules/setting/components/inputTypes/SettingInputTypeSelect';
import SettingInputTypeMultiSelect from '@admin/modules/setting/components/inputTypes/SettingInputTypeMultiSelect';
import SettingInputTypeCheckbox from '@admin/modules/setting/components/inputTypes/SettingInputTypeCheckbox';
import SettingInputTypeRawTextarea from '@admin/modules/setting/components/inputTypes/SettingInputTypeRawTextarea';
import SettingInputTypeText from '@admin/modules/setting/components/inputTypes/SettingInputTypeText';
import SettingInputTypeNumber from '@admin/modules/setting/components/inputTypes/SettingInputTypeNumber';

interface SettingInputTypeProps {

}

const SettingValueInputType: React.FC<SettingInputTypeProps> = ({register, control, formData}) => {
  const settingField = formData.settingField;

  switch (settingField?.inputType) {
    case SettingInputType.SELECT:
      return (
        <SettingInputTypeSelect
          control={control}
          settingField={settingField}
        />
      )
    case SettingInputType.MULTISELECT:
      return (
        <SettingInputTypeMultiSelect
          control={control}
          settingField={settingField}
        />
      )
    case SettingInputType.CHECKBOX:
      return (
        <SettingInputTypeCheckbox
          register={register}
        />
      )
    case SettingInputType.RAW_TEXTAREA:
      return (
        <SettingInputTypeRawTextarea register={register} />
      )
    case SettingInputType.TEXT:
      return (
        <SettingInputTypeText register={register} />
      )
    case SettingInputType.NUMBER:
      return (
        <SettingInputTypeNumber register={register} />
      )
  }

  return null;
}

export default SettingValueInputType;
