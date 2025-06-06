import { Controller } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';

const SettingInputTypeMultiSelect = ({control, settingField}) => {
  return (
    <Controller
      name="value"
      control={control}
      defaultValue={settingField.value}
      rules={{
        ...validationRules.required(),
      }}
      render={({ field, fieldState }) => (
        <ReactSelect
          options={settingField.availableOptions}
          value={field.value}
          onChange={(option) => {
            field.onChange(option);
          }}
          hasError={fieldState.invalid}
          errorMessage={fieldState.error?.message}
          isMulti={true}
        />
      )}

    />
  )
}

export default SettingInputTypeMultiSelect;
