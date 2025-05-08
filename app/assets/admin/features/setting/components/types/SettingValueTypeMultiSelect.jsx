import { Controller } from 'react-hook-form';
import MultiSelect from '@/admin/components/form/controls/MultiSelect';
import { useEffect, useState } from 'react';

const SettingValueTypeMultiSelect = ({formData, control, settingValue, fieldErrors}) => {
  const [selectedOption, setSelectedOption] = useState([]);

  useEffect(() => {
      try {
        const parsed = JSON.parse(formData.value);

        const isEmpty =
          parsed === null ||
          (Array.isArray(parsed) && parsed.length === 0) ||
          (typeof parsed === 'object' && !Array.isArray(parsed) && Object.keys(parsed).length === 0);

        if (!isEmpty && Array.isArray(parsed)) {
          const ids = parsed.map((item) => item.id).filter((id) => typeof id === 'number');
          setSelectedOption(ids);
        } else {
          setSelectedOption([]);
        }
      } catch (e) {
        console.error('Invalid JSON in formData.value', e);
        setSelectedOption([]);
      }
  }, [formData?.settingValue]);

  return (
    <Controller
      name="value"
      control={control}
      defaultValue={[]}
      rules={{
        validate: (value) => {
          try {
            const parsed = JSON.parse(value);
            return Array.isArray(parsed) && parsed.length <= 8
              ? true
              : 'Można wybrać maksymalnie 8 opcji';
          } catch (e) {
            return 'Niepoprawna wartość';
          }
        }
      }}
      render={({ field }) => (
        <div>
          <MultiSelect
            label="Wartość"
            options={settingValue?.value || []}
            selected={selectedOption}
            errorMessage={fieldErrors?.value?.message}
            hasError={!!fieldErrors?.value}
            onChange={(value, checked) => {
              const numericValue = Number(value);
              let newSelected = [];

              if (checked) {
                newSelected = [...selectedOption, numericValue];
              } else {
                newSelected = selectedOption.filter((id) => id !== numericValue);
              }

              const newJson = newSelected
                .map((id) => {
                  const found = settingValue?.value.find((el) => el.value === id);
                  return found ? { id: found.value, name: found.label } : null;
                })
                .filter(Boolean);

              setSelectedOption(newSelected);
              field.onChange(JSON.stringify(newJson));
            }}
          />
        </div>
      )}
    />
  )
}

export default SettingValueTypeMultiSelect;
