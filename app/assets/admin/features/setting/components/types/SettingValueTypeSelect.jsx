import { useEffect, useState } from 'react';
import Select from '@/admin/components/form/controls/Select';
import { Controller } from 'react-hook-form';

const SettingValueTypeSelect = ({formData, control, settingValue}) => {
  const [selectedOption, setSelectedOption] = useState('');

  useEffect(() => {
    if (settingValue && settingValue?.type === 'select') {
      const selectedParse = JSON.parse(formData.value);

      const isEmpty =
        selectedParse === null ||
        (Array.isArray(selectedParse) && selectedParse.length === 0) ||
        (typeof selectedParse === 'object' && !Array.isArray(selectedParse) && Object.keys(selectedParse).length === 0);

      if (!isEmpty) {
        setSelectedOption(settingValue?.value.find((element) => element.value === Number(selectedParse.id)).value);
      }
    }
  }, [formData?.settingValue]);

  return (
    <Controller
      name="value"
      control={control}
      defaultValue={[]}
      render={({ field }) => (
        <div>
          <Select
            label="Wartość"
            options={settingValue?.value || []}
            selected={selectedOption}
            onChange={(value) => {
              let newValue = value;
              setSelectedOption(value);
              const findValue = settingValue?.value.find(
                (element) => element.value === Number(value),
              );
              if (findValue) {
                newValue = {
                  id: findValue.value,
                  name: findValue.label,
                };
              }
              field.onChange(JSON.stringify(newValue));
            }}
          />
        </div>
      )}
      />
  )
}

export default SettingValueTypeSelect;
