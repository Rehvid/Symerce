import { Controller } from 'react-hook-form';
import { validationRules } from '@admin/utils/validationRules';
import { useState } from 'react';
import ReactSelect from '@admin/shared/components/form/reactSelect/ReactSelect';


const SettingInputTypeSelect = ({control, settingField}) => {
  const [isDefaultOptionSelected, setIsDefaultOptionSelected] = useState<boolean>(false);
  const availableOptions = settingField.availableOptions;
  const selectedOption = availableOptions.find(option => option.value === settingField.value);

  return (
    <Controller
      name="value"
      control={control}
      defaultValue={selectedOption}
      rules={{
        ...validationRules.required()
      }}
      render={({ field, fieldState }) => (
        <ReactSelect
          options={settingField.availableOptions}
          value={isDefaultOptionSelected ? field.value : selectedOption}
          onChange={(option) => {
            setIsDefaultOptionSelected(true);
            field.onChange(option);
          }}
          hasError={fieldState.invalid}
          errorMessage={fieldState.error?.message}
        />
      )}

    />
  )
}

export default SettingInputTypeSelect;
